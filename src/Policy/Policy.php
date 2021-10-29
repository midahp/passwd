<?php
declare(strict_types=1);
namespace Horde\Passwd\Policy;
/**
 * Interface of a Password Policy
 */
interface Policy
{
    /**
     * Check a password for the policy
     *
     * @param string $password The password to check
     * @return string|null null if passed, String for issues
     */
    public function check(string $password): ?string;
}