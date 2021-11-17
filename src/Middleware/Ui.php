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
use Horde_Core_Factory_Topbar as Topbar;


class Ui implements MiddlewareInterface 
{
    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    protected Horde_Injector $injector;
    protected Horde_Session $session;
    protected Horde_Registry $registry;
    protected Horde_PageOutput $page_output;
    protected Horde_View $view;
    protected Topbar $topbar;
    

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Horde_Injector $injector,
        Horde_Registry $registry,
        Horde_Session $session,
        Horde_PageOutput $page_output,
        Horde_View $view,
        Topbar $topbar
        
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->injector = $injector;
        $this->registry = $registry;
        $this->session = $session;
        $this->page_output = $page_output;
        $this->view = $view;
        $this->topbar = $topbar;
        
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        global $prefs;
        $ui = $prefs->getValue('dynamic_ui');
        $dynamic = $this->registry->getView() === Horde_Registry::VIEW_DYNAMIC;
        if ($dynamic && $ui == 'material') {
            $session = $GLOBALS['injector']->getInstance(\Horde_Session::class);
            $registry = $GLOBALS['injector']->getInstance(\Horde_Registry::class);

            // getting node information of Horde top-menubar
            $menu = $this->topbar->create('Horde_Tree_Renderer_Nodes', array('nosession' => true));
            $menu =  $menu->getTree();
            $modified = $menu->getNodes();
            $nodes = json_encode($modified);

            // adding information (like info on nodes) to the global Hordevariable
            $jsGlobalsHorde = [
                'appMode' => 'horde',
                'sessionToken' => $session->getToken(),
                'currentApp' => $registry->getApp(),
                'userUid' => $registry->getAuth(),
                'apps' => $registry->listApps(null, true),
                // TODO: Apps always show their English name
                'appWebroot' => $registry->get('webroot', 'passwd'),
                'languageKey' => $registry->preferredLang(),
                'supportedLanguages' => $registry->nlsconfig->languages,
                'nodes' => $nodes
            ];

            
            ob_start();
            
            // das react lädt auch ohne diesen Header. Wenn der Header  hinzugefügt wird, zeigt sich die HTML-Struktur mit den Menufinos
            // $this->page_output->header([
            //     'title' => _("Change Password"),
            //     'view' => $this->registry::VIEW_DYNAMIC,
            // ]);

            $this->page_output->addInlineJsVars([
                'horde' => $jsGlobalsHorde,
            ]);
            
            $this->page_output->addScriptFile('react/runtime-main.release.js');
            $this->page_output->addScriptFile('react/2.release.chunk.js');
            $this->page_output->addScriptFile('react/main.release.chunk.js');
        
            $this->view->addTemplatePath(PASSWD_TEMPLATES);
            echo $this->view->render('react-init');
            $this->page_output->footer();
            $stream = $this->streamFactory->createStream(ob_get_contents());
            ob_end_clean();
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
