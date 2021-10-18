<?php

namespace Horde\Passwd\Handler;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use \Horde_Variables;
use \Horde_Session;
use \Horde_View;

class ReactInit implements RequestHandlerInterface
{
    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    protected Horde_Variables $vars;
    protected Horde_Session $session;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Horde_Variables $vars,
        Horde_Session $session
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->vars = $vars;
        $this->session = $session;
    }

    /**
     * Handle a request
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $userid = $request->getAttribute('HORDE_AUTHENTICATED_USER');

        $jsGlobals = [
            'url' => $this->vars->return_to,
            'userid' => $userid,
            'sessionToken' => $this->session->getToken(),
        ];

        $view = new Horde_View(array(
            'templatePath' => PASSWD_TEMPLATES
        ));
        $view->jsGlobals = json_encode($jsGlobals);
        $body = $this->streamFactory->createStream($view->render('react-init'));
        return $this->responseFactory->createResponse(200)->withBody($body);
    }

}
