# TODO: Implementasi Fitur Role DOSEN

## Status: ✅ Approved by User - Ready to Implement

## Breakdown dari Plan (Sequential Steps)

- [✅] `app/Http/Controllers/Dosen/DosenDashboardController.php` (enhanced)
- [✅] `app/Http/Controllers/Dosen/AttendanceController.php` (new)
- [✅] `app/Http/Controllers/Dosen/MeetingController.php` (new)

### 2. 🔄 Update Existing Core Files

- [✅] `routes/web.php` (add dosen routes)
- [✅] `resources/views/layouts/dosen.blade.php` (add sidebar menus)
- [✅] `resources/views/dosen/dashboard.blade.php` (enhanced dashboard)

### 3. 📄 Create New Views

- [✅] `resources/views/dosen/attendances/index.blade.php`
- [✅] `resources/views/dosen/meetings/index.blade.php`
- [✅] Stubs: `resources/views/dosen/chats/index.blade.php`, `resources/views/dosen/profile.blade.php`, `resources/views/dosen/accounts/index.blade.php`

### 4. 🧪 Testing & Validation

- [ ] Add sample data (schedules, exams, meetings, announcements)
- [ ] Test routes: `php artisan route:list | grep dosen`
- [ ] Manual test: Login dosen → Dashboard → Features
- [ ] ✅ Complete & attempt_completion

**Progress: 0/14 steps completed**

**Next Action:** Start with Step 1 - Create controllers
