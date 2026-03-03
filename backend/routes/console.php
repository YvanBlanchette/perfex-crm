<?php
use Illuminate\Support\Facades\Schedule;

Schedule::command('crm:mark-overdue-invoices')->dailyAt('08:00');
Schedule::command('crm:send-invoice-reminders --days=3')->dailyAt('09:00');
Schedule::command('crm:cleanup-logs --days=90')->weeklyOn(0, '02:00');