<?php

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Implementing this stuff here: https://www.php-fig.org/psr/psr-7/, because Horde cannot deal with psr15 yet (right?)
 */
class Passwd_ApiPasswordReact_Controller implements RequestHandlerInterface
{
    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;

    public function __construct(
        #Passwd_Driver $driver, 
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory
        
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        #$this->driver = $driver;
    }

    /**
     * Handle a request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Array ( [currentPassword] => test [newPassword] => testdfdf [confirmPassword] => testesrer ) 1
        $post = $request->getParsedBody();
        $currentpassword = $post['currentPassword'];
        $newpassword = $post['newPassword'];
        $confirmPassword = $post['confirmPassword'];

        

        $test = "
        <p>currentpassword = ".$post['currentPassword']."</p>
        <p>newpassword = ".$post['newPassword']."</p>
        <p>confirmPassword = ".$post['confirmPassword']."</p>    
        ";

        $body = $this->streamFactory->createStream(print_r($test));
        return $this->responseFactory->createResponse(200)->withBody($body);


        // Passwd_Driver object cal and enter details

        #$this->driver->changePasswd();



        // then: changePassword($user, $oldpass, $newpass)

    }

    /**
     * Determines if the given backend is the "preferred" backend for this web
     * server.
     *
     * This decision is based on the global 'SERVER_NAME' and 'HTTP_HOST'
     * server variables and the contents of the 'preferred' field in the
     * backend's definition.  The 'preferred' field may take a single value or
     * an array of multiple values.
     *
     * @param array $backend  A complete backend entry from the $backends
     *                        hash.
     *
     * @return boolean  True if this entry is "preferred".
     */
    // private function _isPreferredBackend($backend)
    // {
    //     if (!empty($backend['preferred'])) {
    //         if (is_array($backend['preferred'])) {
    //             foreach ($backend['preferred'] as $backend) {
    //                 if ($backend == $_SERVER['SERVER_NAME'] ||
    //                     $backend == $_SERVER['HTTP_HOST']) {
    //                     return true;
    //                 }
    //             }
    //         } elseif ($backend['preferred'] == $_SERVER['SERVER_NAME'] ||
    //                   $backend['preferred'] == $_SERVER['HTTP_HOST']) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }

}
