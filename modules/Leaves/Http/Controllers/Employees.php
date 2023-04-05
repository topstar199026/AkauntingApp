<?php

namespace Modules\Leaves\Http\Controllers;

use App\Abstracts\Http\Controller;
use Modules\Employees\Models\Employee;

class Employees extends Controller
{
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:read-employees-employees')->only(['index']);
    }

    public function index()
    {
        $employees = Employee::select(['employees_employees.*', 'contacts.name as name'])
            ->join('contacts', 'employees_employees.contact_id', '=', 'contacts.id')
            ->collect('name');

        return $this->response('employees::employees.index', compact('employees'));
    }
}
