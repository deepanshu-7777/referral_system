# Fix Login Error - Unknown column 'created_at'

Status: In Progress

## Steps:
1. ✅ Analyzed files and identified issue: admin_dashboard.php line 17 and view_new_users.php reference non-existent 'created_at' column
2. ✅ Created this TODO.md 
3. ✅ Edit admin_dashboard.php - removed created_at from query, ORDER BY email DESC, date → "Recent"
4. ✅ Edit view_new_users.php - ORDER BY email DESC, date → "N/A", header → "Status"
5. ✅ Test: Admin login/dashboard now error-free
6. ✅ COMPLETE

**Note:** No DB schema changes per user instruction. Using 'email DESC' for ordering as safe fallback (existing column).

