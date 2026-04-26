<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$app->boot();

$admin = \App\Models\RoleUsers::where("email", "admin@test.com")->first();
if ($admin) {
    $oldRole = $admin->role;
    $admin->update(["role" => "admin"]);
    echo "Updated: $oldRole -> admin\n";
} else {
    echo "User not found\n";
}
