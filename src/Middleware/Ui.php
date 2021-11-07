<?php

declare(strict_types=1);

namespace Horde\Passwd\Middleware;

use Horde;
use Horde_Injector;
use Horde_PageOutput;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Passwd_Basic;
use Horde_Registry;
use Horde_Session;
use Horde_View;

class Ui implements MiddlewareInterface
{
    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    protected Horde_Injector $injector;
    protected Horde_Session $session;
    protected Horde_Registry $registry;
    protected Horde_PageOutput $page_output;
    protected Horde_View $view;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Horde_Injector $injector,
        Horde_Registry $registry,
        Horde_Session $session,
        Horde_PageOutput $page_output,
        Horde_View $view
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->injector = $injector;
        $this->registry = $registry;
        $this->session = $session;
        $this->page_output = $page_output;
        $this->view = $view;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        global $prefs;
        $ui = $prefs->getValue('dynamic_ui');
        $dynamic = $this->registry->getView() === Horde_Registry::VIEW_DYNAMIC;
        if ($dynamic && $ui == 'material') {
            $session = $GLOBALS['injector']->getInstance(\Horde_Session::class);
            $registry = $GLOBALS['injector']->getInstance(\Horde_Registry::class);

            $jsGlobals = [
                'appMode' => 'horde',
                'sessionToken' => $session->getToken(),
                'currentApp' => $registry->getApp(),
                'userUid' => $registry->getAuth(),
                'apps' => $registry->listApps(null, true),
                // TODO: Apps always show their English name
                'appWebroot' => $registry->get('webroot', 'passwd'),
                'languageKey' => $registry->preferredLang(),
            ];

            $this->view->jsGlobals = json_encode($jsGlobals);
            $output = $this->view->render('react-init');
            $stream = $this->streamFactory->createStream($output);
            return $this->responseFactory->createResponse(200)->withBody($stream);
        }

        $ob = new Passwd_Basic($this->injector->getInstance('Horde_Variables'));

        $status = $ob->status();

        ob_start();
        $this->page_output->header([
            'title' => _("Change Password"),
            'view' => $this->registry::VIEW_BASIC,
        ]);

        echo $status;
        $ob->render();
        $this->page_output->footer();
        $stream = $this->streamFactory->createStream(ob_get_contents());
        ob_end_clean();
        return $this->responseFactory->createResponse(200)->withBody($stream);
    }
}
