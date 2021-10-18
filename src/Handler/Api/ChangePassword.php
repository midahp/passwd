<?php
namespace Horde\Passwd\Handler\Api;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use \Passwd_Driver as Driver;
use \Horde\Core\Config\State as Configuration;
use \Horde_Registry;






// this is for testing and should be removed
use \Horde_Session;



/**
 * Implementing psr-7
 */
class ChangePassword implements RequestHandlerInterface
{

    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    private Driver $driver;
    public Configuration $config;
    private Horde_Registry $registry;
    public $reason;
    public $status;


    // this is for testing and should be removed
    protected Horde_Session $session;
    


   
    public function __construct(
        Horde_Session $session, // this is for testing and should be removed
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Driver $driver,
        Configuration $config,
        Horde_Registry $registry 
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->driver = $driver;
        $this->config = $config;
        $this->registry = $registry;
        // below is for testing and should be removed
        $this->session = $session;
    }

    /**
     * Handle a request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        
        // fertig? mach unittests für den Controller (probleme mit Globals? Mach Mock vom Inhalt von Globals)
        
        
        // testing request object
        $testObjectFromRequest = [
            "username" => "rafael",
            "oldPassword" => "leafar8",
            "newPassword" => "leafar8",
            "newPasswordConfirm" => "leafar8"
        ];
        

        $testObjectFromRequest = json_encode($testObjectFromRequest);

        $token = (string) $this->session->getToken();

        /**
         * Real code for later, now testing with uncommented code below
         */
        
        // $post = $request->getParsedBody();
        // $user = $post['username'];
        // $currentPassword = $post['oldPassword'];
        // $newPassword = $post['newPassword'];
        // $confirmPassword = $post['newPasswordConfirm'];

        $post = json_decode($testObjectFromRequest);
        $user = $post->username;
        $currentPassword = $post->oldPassword;
        $newPassword = $post->newPassword;
        $confirmPassword = $post->newPasswordConfirm;

        $jsonData = ['success' => false, 'message' => ''];


        try {
            $this->verifyPassword($user, $confirmPassword, $currentPassword, $newPassword);
            $this->driver->changePassword($user, $currentPassword, $newPassword);
            $jsonData['success'] = true;
        } catch (\Throwable $th) {
            //throw $th;
            $jsonData['message'] = $th->getMessage();
        }

        $jsonString = json_encode($jsonData);

        /**
        * This is the code that I want to use for the real app. Currently it is commented, because Im testing with the code below.
        * Read below "Why bother?" what i want to impleemnt: https://www.php-fig.org/psr/psr-7/meta/
        * - Also: No Notifications but Status Codes instead
        */ 
        // $body = $this->streamFactory->createStream($jsonString);
        // return $this->responseFactory->createResponse(200)->withBody($body)->withHeader('Content-Type', 'application/json');
    
        $userid = $this->registry->getAuth();
        $userid = $this->registry->getAuthInfo();
        $conf = $this->config->toArray();
        
        
        // testing request object
        $body = $this->streamFactory->createStream($jsonString);
        return $this->responseFactory->createResponse(200)->withBody($body)
        ->withHeader('Horde-Session-Token', $token)
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($this->status, $this->reason);
        
    }

    /**
     * @param string $backend_key  Backend key.
     */
    private function verifyPassword($user, $confirmPassword, $currentPassword, $newPassword )
    {
        
        // Implementiere Checks von basic.php: Extra Notizen mit was noch angepasst werden muss (TODO) (auf English)
          
        
        $conf = $this->config->toArray();
        $registry = $this->registry;
        $userid = $registry->getAuth();
        // $userPassword = $registry->getAuthCredential();
        
       
        // Check for users that cannot change their passwords.
        if (in_array($userid, $conf['user']['refused'])) {
            $this->reason = "You can't change password for user ".$userid."";
            $this->status = 403;
        }
        else{
            $this->status = 200;
        }

        // other checks are in basic.php, will try to take over as many as possible
       
    }

     
}
