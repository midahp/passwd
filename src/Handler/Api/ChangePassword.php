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


/**
 * Implementing psr-7
 */
class ChangePassword implements RequestHandlerInterface
{

    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    private Driver $driver;
    private Configuration $config;
    private Horde_Registry $registry;


    // this is for testing and should be removed
    protected Horde_Session $session;
    


   
    public function __construct(
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
    }

    /**
     * Handle a request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        
        // fertig? mach unittests für den Controller (probleme mit Globals? Mach Mock vom Inhalt von Globals)
      
        /**
         * For testing the code, uncommented code below and comment the line "$post = $request->getParsedBody();"
         */
        //    // testing request object
        //    $testObjectFromRequest = [
        //     "username" => "charles",
        //     "oldPassword" => "test123",
        //     "newPassword" => "test123",
        //     "newPasswordConfirm" => "test123"
        // ];
        // $testObjectFromRequest = json_encode($testObjectFromRequest);
        // $post = json_decode($testObjectFromRequest);
        
        $post = $request->getParsedBody();
        $user = $post->username;
        $currentPassword = $post->oldPassword;
        $newPassword = $post->newPassword;
        $confirmPassword = $post->newPasswordConfirm;

        $jsonData = ['success' => false, 'message' => ''];

        if ($this->verifyPassword($user, $confirmPassword, $currentPassword, $newPassword)) {
            
            try {
                $this->driver->changePassword($user, $currentPassword, $newPassword);
                $jsonData['success'] = true;
                // $jsonData['statuscode'] = $this->status;
            } catch (\Throwable $th) {
                $jsonData['message'] = $th->getMessage();
                $jsonData['success'] = false;
                // $jsonData['statuscode'] = 404;
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

        // For debuggin use: \Horde::debug($response, '/dev/shm/test2', false);
        return $response;

        
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
        $credentials = $registry->getAuthCredential();
        $userPassword = (string) $credentials['password'];

        // output if all below checks pass
        $output = true;
        $this->reason = "";
        $this->status = 200;
        
       
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
        if ($currentPassword !== $userPassword) {
            $this->reason = "Please enter your current password correctly";
            $this->status = (int) 404;
            $output = false;
            return;
        }

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

        // OTHER TESTS FROM BASIC.PHP NOT YET IMPLEMENTED (WILL IMPLEMENT AS MANY AS POSSIBLE AND AS IS USEFULL)
        // $b_ptr = $this->_backends[$backend_key];

        // try {
        //     Horde_Auth::checkPasswordPolicy($this->_vars->newpassword0, isset($b_ptr['policy']) ? $b_ptr['policy'] : array());
        // } catch (Horde_Auth_Exception $e) {
        //     $notification->push($e, 'horde.warning');
        //     return;
        // }

        // // Do some simple strength tests, if enabled in the config file.
        // if (!empty($conf['password']['strengthtests'])) {
        //     try {
        //         Horde_Auth::checkPasswordSimilarity($this->_vars->newpassword0, array($this->_userid, $this->_vars->oldpassword));
        //     } catch (Horde_Auth_Exception $e) {
        //         $notification->push($e, 'horde.warning');
        //         return;
        //     }
        // }     $b_ptr = $this->_backends[$backend_key];

        // try {
        //     Horde_Auth::checkPasswordPolicy($this->_vars->newpassword0, isset($b_ptr['policy']) ? $b_ptr['policy'] : array());
        // } catch (Horde_Auth_Exception $e) {
        //     $notification->push($e, 'horde.warning');
        //     return;
        // }

        // // Do some simple strength tests, if enabled in the config file.
        // if (!empty($conf['password']['strengthtests'])) {
        //     try {
        //         Horde_Auth::checkPasswordSimilarity($this->_vars->newpassword0, array($this->_userid, $this->_vars->oldpassword));
        //     } catch (Horde_Auth_Exception $e) {
        //         $notification->push($e, 'horde.warning');
        //         return;
        //     }
        // }

        return $output;
    }
}
