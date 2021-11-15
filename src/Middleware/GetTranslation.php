<?php

declare(strict_types=1);

namespace Horde\Passwd\Middleware;

use Horde\Core\Translation\Middleware\Api\GetTranslationBase;

/**
 * Returns locale json file for a specific language and namespace.
 */
class GetTranslation extends GetTranslationBase
{
    protected function getData(): array
    {
        return  [
            "application_title" => _("Change password"),
            "change_now" => _("Change now"),
            "helper_text" => [
                "current_password" => _("Please enter your current password"),
                "new_password" => _("Please enter a new password. Multiple constraints (length, complexity) may have to be fulfilled"),
                "new_password_confirm" => _("Please enter your new password another time"),
                "username" => _("Please enter your username (if not filled automatically)")
            ],
            "label" => [
                "current_password" => _("Current password"),
                "new_password" => _("New password"),
                "new_password_confirm" => _("New Password (Confirmation)"),
                "username" => _("Username")
            ],
            "notification_history" => [
                "no_notifications_yet" => _("No notifications yet"),
                "past_notifications" => _("Notifications")
            ],
            "reset" => "Reset",
            "validation_error" => [
                "current_new_not_different" => _("Current and new password must be different"),
                "leading_trailing_spaces" => _("Password must not start or end with spaces"),
                "min_length" => _("New password must at least contain {{min_length}} characters"),
                "min_number_of_numbers" => _("New password must at least contain {{min_number_of_numbers}} number(s)"),
                "new_confirm_different" => _("New password and confirmation do not match")
            ],
        ];
    }
}
