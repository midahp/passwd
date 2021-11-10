<?php
declare(strict_types=1);
namespace Horde\Passwd\Middleware;

use Horde_Registry;
/**
 * Returns locale json file for a specific language and namespace.
 */
class LocaleApi implements MiddlewareInterface
{
    public function __construct(
        Horde_Registry $registry
    )
    {
        $this->registry = $registry;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $localeJsonPath = $registry->get('fileroot', 'passwd') . '/locale/json';
        $match = $request->getAttribute('match');
        $lang = $match['lang'];
        $namespace = $match['namespace'];
        $requestedFile = realpath($localePath . '/' . $lang . '/' . $namespace . '.json');
        if (
            substr($requestedFile, 0, strlen($localeJsonPath)) === $localeJsonPath
            && is_file($requestedFile)
        ) {
            $responseData = file_get_contents($requestedFile);
            $code = 200;
            
        } else {
            $responseData = json_encode([
                'success' => false,
                'msg' => 'not a valid locale/namespace',
            ]);
            $code = 400;
        }
        $body = $this->streamFactory->createStream($responseData);
        return $this->responseFactory
            ->createResponse($code)
            ->withBody($body)
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
