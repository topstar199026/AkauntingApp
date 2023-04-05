<?php

return [

    'name'        => 'Vacaciones',
    'description' => 'Gestiona las ausencias de los empleados.',

    'leaves' => 'Vacaciones|Vacaciones',

    'entitlements' => 'Permiso|Permisos',
    'calendar'     => 'Calendario',

    'policies'    => 'Política|Políticas',
    'leave_types' => 'Tipo de permiso|Tipos de permiso',
    'years'       => 'Año|Años',

    'leave_policy' => 'Política de permisos',
    'leave_year'   => 'Vacaciones',

    'empty' => [
        'entitlements' => 'Las empresas pueden tener distintas políticas de vacaciones para diferentes empleados, por lo que establecerlas y asignar estas políticas a los empleados es importante para la gestión del periodo de vacaciones. Estas asignaciones adicionales se llaman permisos adquiridos.',
    ],

    'default' => [
        'leave_types' => [
            'casual_leave' => [
                'name'        => 'Permiso temporal',
                'description' => 'Este permiso se concede para situaciones no previstas o cuando un empleado necesita disponer de uno o dos días de permiso'
            ],
            'sick_leave'   => [
                'name'        => 'Baja por enfermedad',
                'description' => 'Los empleados pueden hacer uso de este permiso cuando no pueden trabajar debido a una enfermedad personal o a una lesión',
            ],
        ],
        'policies'    => [
            'annual_leave' => [
                'name' => 'Vaciones anuales',
            ],
        ],
    ],

];
