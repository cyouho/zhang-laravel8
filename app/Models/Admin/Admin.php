<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;

    /**
     * 
     */
    public function getAdminId($email)
    {
        $adminId = DB::select('select admin_id from admins where admin_email = ?', [$email]);
        return $adminId;
    }

    /**
     * 
     */
    public function getAdminRole($email)
    {
        $adminRole = DB::select('select role from admins where admin_email = ?', [$email]);
        return $adminRole;
    }
}
