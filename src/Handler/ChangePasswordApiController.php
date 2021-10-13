<?php
namespace Horde\Passwd\Handler;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use \Passwd_Driver as Driver;
use \Horde_Notification;
use PhpParser\Node\Stmt\TryCatch;

/**
 * Implementing this stuff here: https://www.php-fig.org/psr/psr-7/, because Horde cannot deal with psr15 yet (right?)
 */
class ChangePasswordApiController implements RequestHandlerInterface
{

    protected ResponseFactoryInterface $responseFactory;
    protected StreamFactoryInterface $streamFactory;
    private Driver $driver;


   
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Driver $driver
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->driver = $driver;
    }

    /**
     * Handle a request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        
        // This the output: Array ( [currentPassword] => test [newPassword] => testdfdf [confirmPassword] => testesrer ) 1
        // test
        $post = $request->getParsedBody();
        $user = $post['user'];
        $user = "administrator";
        $currentPassword = $post['currentPassword'];
        $newPassword = $post['newPassword'];
        $confirmPassword = $post['confirmPassword'];

        

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

        
    
        $body = $this->streamFactory->createStream($jsonString);
        return $this->responseFactory->createResponse(200)->withBody($body);
        
    }

    /**
     * @param string $backend_key  Backend key.
     */
    private function verifyPassword($user, $confirmPassword, $currentPassword, $newPassword )
    {
        return;
     
        // Implementiere alles sodass es funktioniert: Extra Notizen mit was noch angepasst werden muss (TODO) (auf English)

        $this->vars = $GLOBALS['injector']->getInstance('Horde_Variables');
        
        // THIS SHOULD BE DONE BY MIDDLEWARE?
        // 
        // Check for users that cannot change their passwords.
        // if (in_array($this->_userid, $conf['user']['refused'])) {
        //     $notification->push(sprintf(_("You can't change password for user %s"), $userid), 'horde.error');
        //     return;
        // }

        // // We must be passed the old (current) password.
        // if (!isset($this->_vars->oldpassword)) {
        //     $notification->push(_("You must give your current password"), 'horde.warning');
        //     return;
        // }

        // if (!isset($this->_vars->newpassword0)) {
        //     $notification->push(_("You must give your new password"), 'horde.warning');
        //     return;
        // }
        // if (!isset($this->_vars->newpassword1)) {
        //     $notification->push(_("You must verify your new password"), 'horde.warning');
        //     return;
        // }

        // if ($this->_vars->newpassword0 != $this->_vars->newpassword1) {
        //     $notification->push(_("Your new passwords didn't match"), 'horde.warning');
        //     return;
        // }

        // if ($this->_vars->newpassword0 == $this->_vars->oldpassword) {
        //     $notification->push(_("Your new password must be different from your current password"), 'horde.warning');
        //     return;
        // }

        $b_ptr = $this->_backends[$backend_key];

        try {
            Horde_Auth::checkPasswordPolicy($this->_vars->newpassword0, isset($b_ptr['policy']) ? $b_ptr['policy'] : array());
        } catch (Horde_Auth_Exception $e) {
            $notification->push($e, 'horde.warning');
            return;
        }

        // Do some simple strength tests, if enabled in the config file.
        if (!empty($conf['password']['strengthtests'])) {
            try {
                Horde_Auth::checkPasswordSimilarity($this->_vars->newpassword0, array($this->_userid, $this->_vars->oldpassword));
            } catch (Horde_Auth_Exception $e) {
                $notification->push($e, 'horde.warning');
                return;
            }
        }

        try {
            $driver = $injector->getInstance('Passwd_Factory_Driver')->create($backend_key);
        } catch (Passwd_Exception $e) {
            Horde::log($e);
            $notification->push(_("Password module is not properly configured"), 'horde.error');
            return;
        }

        try {
            $driver->changePassword(
                $this->_userid,
                $this->_vars->oldpassword,
                $this->_vars->newpassword0
            );
        } catch (Exception $e) {
            $notification->push(sprintf(_("Failure in changing password for %s: %s"), $b_ptr['name'], $e->getMessage()), 'horde.error');
            return;
        }

        $notification->push(sprintf(_("Password changed on %s."), $b_ptr['name']), 'horde.success');

        try {
            Horde::callHook('password_changed', array($this->_userid, $this->_vars->oldpassword, $this->_vars->newpassword0), 'passwd');
        } catch (Horde_Exception_HookNotSet $e) {}

        if (!empty($b_ptr['logout'])) {
            $logout_url = $registry->getLogoutUrl(array(
                'msg' => _("Your password has been succesfully changed. You need to re-login to the system with your new password."),
                'reason' => Horde_Auth::REASON_MESSAGE
            ));
            $registry->clearAuth();
            $logout_url->redirect();
        }

        if ($url = Horde::verifySignedUrl($this->_vars->return_to)) {
            $url = new Horde_Url($url);
            $url->redirect();
        }
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
    private function _isPreferredBackend($backend)
    {
        if (!empty($backend['preferred'])) {
            if (is_array($backend['preferred'])) {
                foreach ($backend['preferred'] as $backend) {
                    if ($backend == $_SERVER['SERVER_NAME'] ||
                        $backend == $_SERVER['HTTP_HOST']) {
                        return true;
                    }
                }
            } elseif ($backend['preferred'] == $_SERVER['SERVER_NAME'] ||
                      $backend['preferred'] == $_SERVER['HTTP_HOST']) {
                return true;
            }
        }

        return false;
    }

}
