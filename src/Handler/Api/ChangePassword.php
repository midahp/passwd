<?php
namespace Horde\Passwd\Handler\Api;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use \Passwd_Factory_Driver as Factorydriver;
use \Passwd_Driver as Driver;
use \Horde\Core\Config\State as Configuration;
use \Horde_Registry;
use \Horde_Auth;
use \Horde_Auth_Exception;


/**
 * Implementing psr-7
 */
class ChangePassword implements RequestHandlerInterface
{

    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    private Driver $driver;
    private Factorydriver $backendchecker;
    public Configuration $config;
    private Horde_Registry $registry;
    public $reason;
    public $status;
    


   
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Driver $driver,
        Factorydriver $backendchecker,
        Configuration $config,
        Horde_Registry $registry 
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->driver = $driver;
        $this->backendchecker = $backendchecker;
        $this->config = $config;
        $this->registry = $registry;
    }

    /**
     * Handle a request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
       
        $post = $request->getParsedBody();
        $post = json_encode($post);
        $post = json_decode($post);

        $user = $post->userid;
        \Horde::debug($user, '/dev/shm/test2', false);
        $currentPassword = $post->oldpassword;
        $newPassword = $post->newpassword0;
        $confirmPassword = $post->newpassword1;

        $jsonData = ['success' => false, 'message' => ''];

        if ($this->verifyPassword($user, $confirmPassword, $currentPassword, $newPassword)) {
            
            try {
                $this->driver->changePassword($user, $currentPassword, $newPassword);
                $jsonData['success'] = true;
            } catch (\Throwable $th) {
                $jsonData['message'] = $th->getMessage();
                $jsonData['success'] = false;
            }
        }
         else  {
            $jsonData['message'] = $this->reason;
            $jsonData['success'] = false;
            
        }

        $jsonString = json_encode($jsonData);

        // sending the response object
        $body = $this->streamFactory->createStream($jsonString);
        $response = $this->responseFactory->createResponse($this->status, $this->reason)->withBody($body)
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($this->status, $this->reason);

        return $response;
    }
    
    /**
     * @param string $backend_key  Backend key.
     */
    private function verifyPassword($user, $confirmPassword, $currentPassword, $newPassword )
    {
        
        // Implementiere Checks von basic.php: Extra Notizen mit was noch angepasst werden muss (TODO) (auf English)
          
        
        $conf = $this->config->toArray();
        $registry = $this->registry; // important: with each reload this shoud load again...
        $userid = $registry->getAuth();
        $credentials = $registry->getAuthCredential();
        $userPassword = (string) $credentials['password'];

        // output if all below checks pass
        $output = true;
        $this->reason = "";
        $this->status = 200;

        // loading backendinfos
        $backend = $this->backendchecker->__get('backends');
        $backend = $backend['hordeauth'];
        // \Horde::debug($backend["minLength"], '/dev/shm/test1', false);
        
       
        // check if the username is the correct username... users can only change their own passwords right?
        if ($userid !== $user){
            $this->reason = "You can't change password for user ".$user.". Please enter your own correct username.";
            $this->status = (int) 403;
            $output = false;
            return;
        }
        
        // Check for users that cannot change their passwords.
        if (in_array($userid, $conf['user']['refused'])) {
            $this->reason = "You do dont have permission to change password as user ".$user."";
            $this->status = (int) 403;
            $output = false;
            return;
        }   
        
        // Check that oldpassword is current password
        // if ($currentPassword !== $userPassword) {
        //     $this->reason = "Please enter your current password correctly ";
        //     $this->status = (int) 404;
        //     $output = false;
        //     return;
        // }

        // check that new password is different from old password
        if ($currentPassword == $newPassword) {
            $this->reason = "Please enter a different password";
            $this->status = (int) 404;
            $output = false;
            return;
        }

        // Check that the new password is typed correctly
        if ($newPassword !== $confirmPassword){
            $this->reason = "Please make sure you enter your new password correctly";
            $this->status = (int) 404;
            $output = false;
            return;
        }

                        
        // Check for password policies
        try {
            Horde_Auth::checkPasswordPolicy($newPassword, isset($backend['policy']) ? $backend['policy'] : array());
        } catch (Horde_Auth_Exception $e) {
            $this->status = 404;
            $this->reason = (string) $e; //this shows the whole error message and should maybe be done differently
            $output = false;
            return;
        }

        // Do some simple strength tests, if enabled in the config file.
        if (!empty($conf['password']['strengthtests'])) {
            try {
                Horde_Auth::checkPasswordSimilarity($newPassword, array($userid, $currentPassword));
            } catch (Horde_Auth_Exception $e) {
                $this->status = 404;
                $this->reason = (string) $e; //this shows the whole error message and should maybe be done differently
                $output = false;
                return;
            }
        }     
        return $output;
    }
}
