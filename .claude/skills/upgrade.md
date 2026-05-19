# Upgrade Skill — API Template Version Manager

Upgrades this project (odo-api) from its current template version to a newer one.

**Template source:** `../client-api/`
**Version file:** `.template-version` at this project's root
**Migration guide:** `../client-api/.claude/CHANGELOG.md`

---

## Usage

`/upgrade` — detect current version, show available upgrades, ask which to apply
`/upgrade to 2.0` — run the v1→v2 upgrade

---

## How This Works

1. Read `.template-version` to get the current version
2. Read `../client-api/.claude/CHANGELOG.md` to get available upgrades
3. Build the upgrade path (e.g. 1.0 → 2.0, or 1.0 → 2.0 → 3.0)
4. Present a summary of what will change and ask for confirmation
5. Execute each STEP in order, pausing at any MERGE steps to show a diff
6. Update `.template-version` ONLY after all steps complete successfully

---

## Rules

- **Additive first:** always copy new files before modifying existing ones
- **Never overwrite without comparing:** for any file marked ⚠️ in the CHANGELOG,
  read both the template version and the consumer version, then merge manually
- **Preserve consumer customisations:** cookie names, client-specific routes,
  business logic in existing controllers — do NOT blindly overwrite
- **DB migrations are irreversible:** confirm before running `php spark migrate`
- **One step at a time:** complete and verify each STEP before moving to the next
- **Working directory:** all paths are relative to `odo-api/` (this project root)
  unless prefixed with `../client-api/`

---

## Conflict Resolution

When a file exists in both consumer and template, read both and decide:

| Scenario | Action |
|----------|--------|
| Template file is identical | Skip (nothing to do) |
| Consumer file has client-specific data (cookie name, domain, colors) | Merge — keep consumer values, add template additions |
| Template file has new constants/methods, consumer has customisations | Add new parts to consumer file without removing existing |
| File is entirely new in template (doesn't exist in consumer) | Copy as-is |

---

## Current Project Notes

- v1 architecture uses **direct query builder** in controllers (no Domain layer)
- Existing controllers in `app/Infrastructure/Http/Controllers/Admin/` and
  `app/Infrastructure/Http/Controllers/Content/` must NOT be blindly overwritten
- Admin cookie name may differ from template — check `app/Filters/AdminAuth.php`
- The `CreateCoreTables` migration already created `newsletters` and `documents`
  tables — skip those separate migrations in the v2 CHANGELOG if they already exist
- Run `php spark migrate:status` before applying any DB migrations to see what's pending

---

## After Upgrade

1. Run `php spark migrate` to apply new DB migrations
2. Run `composer install --no-dev` if new dependencies were added
3. Test all existing endpoints still work
4. Test new endpoints return expected status codes
5. Update `.template-version` to the new version number
6. Commit: `git add -A && git commit -m "chore: upgrade template to v{X.X}"`
