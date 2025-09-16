<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;
use App\Models\Role;

class PermissionTableSeeder extends Seeder
{
    const UNIT_DASHBOARD = 1;

    const UNIT_CLIENT_PROFILE = 2;
    const UNIT_CLIENT_CARE_PLANS = 3;
    const UNIT_CLIENT_MEDICAL = 4;
    const UNIT_CLIENT_SCHEDULE = 5;
    const UNIT_CLIENT_VISIT = 6;
    const UNIT_CLIENT_NOTE = 7;
    const UNIT_CLIENT_SHIFT_NOTE = 22;

    const UNIT_EMPLOYEE_PROFILE = 8;
    const UNIT_EMPLOYEE_SCHEDULE = 9;
    const UNIT_EMPLOYEE_VISIT = 10;
    const UNIT_EMPLOYEE_NOTE = 11;

    const UNIT_USER = 12;
    const UNIT_COMPANY = 13;
    const UNIT_ROLE = 14;
    const UNIT_PERMISSION = 15;
    const UNIT_SETTING = 16;
    const UNIT_UNIT = 17;
    const UNIT_UNIT_CATEGORY = 18;
    const UNIT_BODY_AREA = 19;
    const UNIT_SCHEDULE_TYPE = 20;
    const UNIT_VISIT_BODY_AREA = 21;
    const UNIT_EMPLOYEE_SHIFT_NOTE = 22;

    /**
     * @return void
     */
    public function run()
    {
        //  Permission::truncate();

        $permissions = [
            // Users
            'user' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_USER, 'action' => null],
                ['unit_id' => self::UNIT_USER, 'action' => null, 'title' => __('User unit visibility')]
            ),
            'user.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_USER, 'action' => 'each'],
                ['unit_id' => self::UNIT_USER, 'action' => 'each', 'title' => __('See Each User possibility')]
            ),
            'user.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_USER, 'action' => 'company'],
                ['unit_id' => self::UNIT_USER, 'action' => 'company', 'title' => __('See Company User possibility')]
            ),
            'user.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_USER, 'action' => 'edit'],
                ['unit_id' => self::UNIT_USER, 'action' => 'edit', 'title' => __('Editing User possibility')]
            ),
            'user.editRoles' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_USER, 'action' => 'edit'],
                ['unit_id' => self::UNIT_USER, 'action' => 'edit', 'title' => __('Editing User Roles possibility')],
            ),
            'user.roleAdmin' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_USER, 'action' => 'edit'],
                ['unit_id' => self::UNIT_USER, 'action' => 'edit', 'title' => __('Has Admin Role possibility')],
            ),

            // Client Profiles
            'clientProfile' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => null, 'title' => __('Client profile unit visibility')]
            ),
            'clientProfile.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => 'each', 'title' => __('See Each Client Profile possibility')]
            ),
            'clientProfile.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => 'company', 'title' => __('See Company Client Profile possibility')]
            ),
            'clientProfile.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_PROFILE, 'action' => 'edit', 'title' => __('Editing Client Profile possibility')]
            ),

            // Client Care Plans
            'clientCarePlans' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => null, 'title' => __('Client care plans unit visibility')]
            ),
            'clientCarePlans.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => 'each', 'title' => __('See Each Client Care Plan possibility')]
            ),
            'clientCarePlans.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => 'company', 'title' => __('See Company Client Care Plans possibility')]
            ),
            'clientCarePlans.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_CARE_PLANS, 'action' => 'edit', 'title' => __('Editing Client Care Plans possibility')]
            ),

            // Client Medical
            'clientMedical' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => null, 'title' => __('Client medical unit visibility')]
            ),
            'clientMedical.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => 'each', 'title' => __('See Each Client Medical Record possibility')]
            ),
            'clientMedical.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => 'company', 'title' => __('See Company Client Medical Records possibility')]
            ),
            'clientMedical.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_MEDICAL, 'action' => 'edit', 'title' => __('Editing Client Medical Records possibility')]
            ),

            // Client Schedules
            'clientSchedule' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => null, 'title' => __('Client schedule unit visibility')]
            ),
            'clientSchedule.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'each', 'title' => __('See Each Client Schedule possibility')]
            ),
            'clientSchedule.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'company', 'title' => __('See Company Client Schedule possibility')]
            ),
            'clientSchedule.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'edit', 'title' => __('Editing Client Schedule possibility')]
            ),

            // Client Visits
            'clientVisit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => null, 'title' => __('Client visit unit visibility')]
            ),
            'clientVisit.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => 'each', 'title' => __('See Each Client Visit possibility')]
            ),
            'clientVisit.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => 'company', 'title' => __('See Company Client Visits possibility')]
            ),
            'clientVisit.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_VISIT, 'action' => 'edit', 'title' => __('Editing Client Visits possibility')]
            ),

            // Client Notes
            'clientNote' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => null, 'title' => __('Client note unit visibility')]
            ),
            'clientNote.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => 'each', 'title' => __('See Each Client Note possibility')]
            ),
            'clientNote.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => 'company', 'title' => __('See Company Client Notes possibility')]
            ),
            'clientNote.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_NOTE, 'action' => 'edit', 'title' => __('Editing Client Notes possibility')]
            ),

            // Client Shift Notes
            'clientShiftNote' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => null],
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => null, 'title' => __('Client Shift Notes unit visibility')]
            ),
            'clientShiftNote.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => 'each'],
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => 'each', 'title' => __('See Each Client Shift Notes possibility')]
            ),
            'clientShiftNote.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => 'company'],
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => 'company', 'title' => __('See Company Client Shift Notes possibility')]
            ),
            'clientShiftNote.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_SHIFT_NOTE, 'action' => 'edit', 'title' => __('Editing Client Shift Notes possibility')]
            ),

            // Employee Profiles
            'employeeProfile' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => null],
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => null, 'title' => __('Employee profile unit visibility')]
            ),
            'employeeProfile.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => 'each'],
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => 'each', 'title' => __('See Each Employee Profile possibility')]
            ),
            'employeeProfile.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => 'company'],
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => 'company', 'title' => __('See Company Employee Profiles possibility')]
            ),
            'employeeProfile.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_EMPLOYEE_PROFILE, 'action' => 'edit', 'title' => __('Editing Employee Profiles possibility')]
            ),

            // EMPLOYEE Schedules
            'employeeSchedule' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SCHEDULE, 'action' => null],
                ['unit_id' => self::UNIT_EMPLOYEE_SCHEDULE, 'action' => null, 'title' => __('Employee Schedule unit visibility')]
            ),
            'employeeSchedule.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SCHEDULE, 'action' => 'each'],
                ['unit_id' => self::UNIT_EMPLOYEE_SCHEDULE, 'action' => 'each', 'title' => __('See Each Employee Schedule possibility')]
            ),
            'employeeSchedule.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SCHEDULE, 'action' => 'company'],
                ['unit_id' => self::UNIT_EMPLOYEE_SCHEDULE, 'action' => 'company', 'title' => __('See Company Employee Schedule possibility')]
            ),
            'employeeSchedule.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_CLIENT_SCHEDULE, 'action' => 'edit', 'title' => __('Editing Employee Schedule possibility')]
            ),

            // Employee Visits
            'employeeVisit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => null],
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => null, 'title' => __('Employee visit unit visibility')]
            ),
            'employeeVisit.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => 'each'],
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => 'each', 'title' => __('See Each Employee Visit possibility')]
            ),
            'employeeVisit.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => 'company'],
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => 'company', 'title' => __('See Company Employee Visits possibility')]
            ),
            'employeeVisit.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => 'edit'],
                ['unit_id' => self::UNIT_EMPLOYEE_VISIT, 'action' => 'edit', 'title' => __('Editing Employee Visits possibility')]
            ),

            // Employee Notes
            'employeeNote' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => null],
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => null, 'title' => __('Employee note unit visibility')]
            ),
            'employeeNote.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => 'each'],
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => 'each', 'title' => __('See Each Employee Note possibility')]
            ),
            'employeeNote.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => 'company'],
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => 'company', 'title' => __('See Company Employee Notes possibility')]
            ),
            'employeeNote.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_EMPLOYEE_NOTE, 'action' => 'edit', 'title' => __('Editing Employee Notes possibility')]
            ),

            // Employee Shift Notes
            'employeeShiftNote' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => null],
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => null, 'title' => __('Employee Shift Note unit visibility')]
            ),
            'employeeShiftNote.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => 'each'],
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => 'each', 'title' => __('See Each Employee Shift Note possibility')]
            ),
            'employeeShiftNote.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => 'company'],
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => 'company', 'title' => __('See Company Employee Shift Notes possibility')]
            ),
            'employeeShiftNote.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => 'edit'],
                ['unit_id' => self::UNIT_EMPLOYEE_SHIFT_NOTE, 'action' => 'edit', 'title' => __('Editing Employee Shift Notes possibility')]
            ),

            // Visit Body Area
            'visitBodyArea' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => null],
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => null, 'title' => __('Visit Body Area unit visibility')]
            ),
            'visitBodyArea.each' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => 'each'],
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => 'each', 'title' => __('See Each Visit Body Area possibility')]
            ),
            'visitBodyArea.company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => 'each'],
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => 'each', 'title' => __('See Company Visit Body Area possibility')]
            ),
            'visitBodyArea.edit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => 'edit'],
                ['unit_id' => self::UNIT_VISIT_BODY_AREA, 'action' => 'edit', 'title' => __('Editing Visit Body Area possibility')]
            ),

            // Others
            'company' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_COMPANY, 'action' => null],
                ['unit_id' => self::UNIT_COMPANY, 'action' => null, 'title' => __('Company unit visibility')]
            ), // Companies
            'role' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_ROLE, 'action' => null],
                ['unit_id' => self::UNIT_ROLE, 'action' => null, 'title' => __('Role unit visibility')]
            ), // Roles
            'permission' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_PERMISSION, 'action' => null],
                ['unit_id' => self::UNIT_PERMISSION, 'action' => null, 'title' => __('Permission unit visibility')]
            ), // Permissions
            'setting' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_SETTING, 'action' => null],
                ['unit_id' => self::UNIT_SETTING, 'action' => null, 'title' => __('Setting unit visibility')]
            ), // Settings
            'unit' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_UNIT, 'action' => null],
                ['unit_id' => self::UNIT_UNIT, 'action' => null, 'title' => __('Unit list visibility')]
            ), // Units
            'unitCategory' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_UNIT_CATEGORY, 'action' => null],
                ['unit_id' => self::UNIT_UNIT_CATEGORY, 'action' => null, 'title' => __('Unit Category unit visibility')]
            ), // Unit Categories
            'bodyArea' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_BODY_AREA, 'action' => null],
                ['unit_id' => self::UNIT_BODY_AREA, 'action' => null, 'title' => __('Body Area unit visibility')]
            ), // Body Area
            'scheduleType' => Permission::updateOrCreate(
                ['unit_id' => self::UNIT_SCHEDULE_TYPE, 'action' => null],
                ['unit_id' => self::UNIT_SCHEDULE_TYPE, 'action' => null, 'title' => __('Schedule Type unit visibility')],
            ), // Schedule Type
        ];

        // Mobile API permissions
        $mobileApiClockUnitId = Unit::where('slug', 'mobile-api.clock')->value('id');
        $scheduleUnitId = Unit::where('slug', 'mobile-api.schedule')->value('id');

        $permissions['mobile.clock.view'] = Permission::updateOrCreate(
            ['unit_id' => $mobileApiClockUnitId, 'action' => 'view'],
            ['unit_id' => $mobileApiClockUnitId, 'action' => 'view', 'title' => __('API Get Clock In Dashboard')]
        );

        $permissions['mobile.clock.clock_in'] = Permission::updateOrCreate(
            ['unit_id' => $mobileApiClockUnitId, 'action' => 'clock_in'],
            ['unit_id' => $mobileApiClockUnitId, 'action' => 'clock_in', 'title' => __('API Set Clock In')]
        );

        $permissions['mobile.schedule.view'] = Permission::updateOrCreate(
            ['unit_id' => $scheduleUnitId, 'action' => 'view'],
            ['unit_id' => $scheduleUnitId, 'action' => 'view', 'title' => __('View schedule via API')]
        );

        $superAdminRole = Role::find(Role::ROLE_ID_SUPER_ADMIN);
        $companyAdminRole = Role::find(Role::ROLE_ID_COMPANY_ADMIN);
        $careWorkerRole = Role::find(Role::ROLE_ID_CARE_WORKER);
        $patientRole = Role::find(Role::ROLE_ID_PATIENT);

        $superAdminItems = [
            $permissions['user'],
            $permissions['user.edit'],
            $permissions['user.each'],
            $permissions['user.company'],
            $permissions['user.editRoles'],
            $permissions['user.roleAdmin'],

            $permissions['clientProfile'],
            $permissions['clientProfile.company'],
            $permissions['clientProfile.each'],
            $permissions['clientProfile.edit'],

            $permissions['clientMedical'],
            $permissions['clientMedical.company'],
            $permissions['clientMedical.each'],
            $permissions['clientMedical.edit'],

            $permissions['clientVisit'],
            $permissions['clientVisit.company'],
            $permissions['clientVisit.each'],
            $permissions['clientVisit.edit'],

            $permissions['clientSchedule'],
            $permissions['clientSchedule.company'],
            $permissions['clientSchedule.each'],
            $permissions['clientSchedule.edit'],

            $permissions['clientCarePlans'],
            $permissions['clientCarePlans.company'],
            $permissions['clientCarePlans.each'],
            $permissions['clientCarePlans.edit'],

            $permissions['clientNote'],
            $permissions['clientNote.company'],
            $permissions['clientNote.each'],
            $permissions['clientNote.edit'],

            $permissions['clientShiftNote'],
            $permissions['clientShiftNote.company'],
            $permissions['clientShiftNote.each'],
            $permissions['clientShiftNote.edit'],

            $permissions['employeeProfile'],
            $permissions['employeeProfile.company'],
            $permissions['employeeProfile.each'],
            $permissions['employeeProfile.edit'],

            $permissions['employeeVisit'],
            $permissions['employeeVisit.company'],
            $permissions['employeeVisit.each'],
            $permissions['employeeVisit.edit'],

            $permissions['employeeSchedule'],
            $permissions['employeeSchedule.company'],
            $permissions['employeeSchedule.each'],
            $permissions['employeeSchedule.edit'],

            $permissions['employeeNote'],
            $permissions['employeeNote.company'],
            $permissions['employeeNote.each'],
            $permissions['employeeNote.edit'],

            $permissions['employeeShiftNote'],
            $permissions['employeeShiftNote.company'],
            $permissions['employeeShiftNote.each'],
            $permissions['employeeShiftNote.edit'],

            //other
            $permissions['visitBodyArea'],
            $permissions['visitBodyArea.company'],
            $permissions['visitBodyArea.each'],
            $permissions['visitBodyArea.edit'],
            $permissions['company'],
            $permissions['role'],
            $permissions['permission'],
            $permissions['setting'],
            $permissions['unit'],
            $permissions['unitCategory'],
            $permissions['bodyArea'],
            $permissions['scheduleType'],

            $permissions['mobile.clock.view'],
            $permissions['mobile.clock.clock_in'],
            $permissions['mobile.schedule.view'],
        ];

        $companyAdminItems = [
            $permissions['user'],
            $permissions['user.edit'],
            $permissions['user.company'],
            $permissions['user.editRoles'],

            $permissions['clientProfile'],
            $permissions['clientProfile.company'],
            $permissions['clientProfile.edit'],

            $permissions['clientMedical'],
            $permissions['clientMedical.company'],
            $permissions['clientMedical.edit'],

            $permissions['clientVisit'],
            $permissions['clientVisit.company'],
            $permissions['clientVisit.edit'],

            $permissions['clientSchedule'],
            $permissions['clientSchedule.company'],
            $permissions['clientSchedule.edit'],

            $permissions['clientCarePlans'],
            $permissions['clientCarePlans.company'],
            $permissions['clientCarePlans.edit'],

            $permissions['clientNote'],
            $permissions['clientNote.company'],
            $permissions['clientNote.edit'],

            $permissions['clientShiftNote'],
            $permissions['clientShiftNote.company'],
            $permissions['clientShiftNote.edit'],

            $permissions['employeeProfile'],
            $permissions['employeeProfile.company'],
            $permissions['employeeProfile.edit'],

            $permissions['employeeVisit'],
            $permissions['employeeVisit.company'],
            $permissions['employeeVisit.edit'],

            $permissions['employeeSchedule'],
            $permissions['employeeSchedule.company'],
            $permissions['employeeSchedule.edit'],

            $permissions['employeeNote'],
            $permissions['employeeNote.company'],
            $permissions['employeeNote.edit'],

            $permissions['employeeShiftNote'],
            $permissions['employeeShiftNote.company'],
            $permissions['employeeShiftNote.edit'],

            $permissions['mobile.clock.view'],
            $permissions['mobile.clock.clock_in'],
            $permissions['mobile.schedule.view'],
        ];

        $careWorkerItems = [
            $permissions['clientProfile'],
            $permissions['clientProfile.company'],
            $permissions['clientProfile.edit'],

            $permissions['clientMedical'],
            $permissions['clientMedical.company'],
            $permissions['clientMedical.edit'],

            $permissions['clientVisit'],
            $permissions['clientVisit.company'],
            $permissions['clientVisit.edit'],

            $permissions['clientSchedule'],
            $permissions['clientSchedule.company'],
            $permissions['clientSchedule.edit'],

            $permissions['clientCarePlans'],
            $permissions['clientCarePlans.company'],
            $permissions['clientCarePlans.edit'],

            $permissions['clientNote'],
            $permissions['clientNote.company'],
            $permissions['clientNote.edit'],

            $permissions['clientShiftNote'],
            $permissions['clientShiftNote.company'],
            $permissions['clientShiftNote.edit'],

            $permissions['employeeShiftNote'],
            $permissions['employeeShiftNote.company'],
            $permissions['employeeShiftNote.edit'],

            $permissions['mobile.clock.view'],
            $permissions['mobile.clock.clock_in'],
            $permissions['mobile.schedule.view'],
        ];

        $patientItems = [
            $permissions['clientProfile'],
            $permissions['clientProfile.company'],
            $permissions['clientProfile.edit'],

            $permissions['clientMedical'],
            $permissions['clientMedical.company'],
            $permissions['clientMedical.edit'],

            $permissions['clientVisit'],
            $permissions['clientVisit.company'],
            $permissions['clientVisit.edit'],

            $permissions['clientSchedule'],
            $permissions['clientSchedule.company'],
            $permissions['clientSchedule.edit'],

            $permissions['clientCarePlans'],
            $permissions['clientCarePlans.company'],
            $permissions['clientCarePlans.edit'],

            $permissions['clientNote'],
            $permissions['clientNote.company'],
            $permissions['clientNote.edit'],

            $permissions['clientShiftNote'],
            $permissions['clientShiftNote.company'],
            $permissions['clientShiftNote.edit'],

            $permissions['mobile.clock.view'],
            $permissions['mobile.clock.clock_in'],
            $permissions['mobile.schedule.view'],
        ];

        $superAdminRole->permissions()->syncWithoutDetaching(array_map(fn($p) => $p->id, $superAdminItems));
        $companyAdminRole->permissions()->syncWithoutDetaching(array_map(fn($p) => $p->id, $companyAdminItems));
        $careWorkerRole->permissions()->syncWithoutDetaching(array_map(fn($p) => $p->id, $careWorkerItems));
        $patientRole->permissions()->syncWithoutDetaching(array_map(fn($p) => $p->id, $patientItems));
    }
}
