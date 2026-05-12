# Task: Multi-Step Verification Workflow

## Completed
- [x] Analyze current workflow suboptimalities.
- [x] Update `plans/workflow_improvement.md` with revised logic.
- [x] Check database state.
- [x] Modify `PenilaianController`:
    - [x] Remove fuzzy trigger from `store`.
    - [x] Add fuzzy trigger to `verifikasi` for `terverifikasi` status.
    - [x] Add guard to `validasi`.
- [x] Update `routes/web.php` to allow role-based access to assessments.
- [x] Update UI:
    - [x] `penilaian/index`: Add status column & role-based action buttons.
    - [x] `penduduk/show`: Update SPK result card with status awareness.
    - [x] Fix `ParseError` in `show.blade.php` (nested logic fix).
    - [x] Harmonize status colors across all index views.
    - [x] Add direct Create/Edit Rumah links in `penduduk/index`.
- [x] Add eager loading for `rumah` and `penilaian` in `PendudukController@index`.

## Pending
- [ ] Verification of data locking (Edit/Delete restriction).
- [ ] Validation of role-based visibility.
