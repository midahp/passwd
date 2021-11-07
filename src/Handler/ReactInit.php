<?php

namespace Horde\Passwd\Handler;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Horde_Variables;
use Horde_Session;
use Horde_View;
use Horde_PageOutput;

class ReactInit implements RequestHandlerInterface
{
    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    protected Horde_Variables $vars;
    protected Horde_Session $session;
    protected Horde_PageOutput $page_output;


    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Horde_Variables $vars,
        Horde_Session $session,
        Horde_PageOutput $page_output
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->vars = $vars;
        $this->session = $session;
        $this->page_output = $page_output;
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
            'languageKey' => 'de', //this is needed otherwise error "thisGlobal.horde.languageKey is not defined":
        ];


        $view = new Horde_View([
            'templatePath' => PASSWD_TEMPLATES,
        ]);



        // $this->page_output->addScriptFile("3run.js");
        $this->page_output->addScriptFile("main.js");
        $this->page_output->addScriptFile("chunk.js");
        $this->page_output->footer(); //without the footer js will not be included. Question: where is the js? I cannot see where it is loaded although it is loaded

        $output = $view->render('react-init');

        $body = $this->streamFactory->createStream($output);

        return $this->responseFactory->createResponse(200)->withBody($body);
    }
}
