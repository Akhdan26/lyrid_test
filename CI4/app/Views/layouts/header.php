<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'App') ?> - CI4 App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 250px; }
        body { background: #f4f6f9; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0; background: linear-gradient(135deg, #1e293b, #0f172a); overflow-y: auto; z-index: 100; }
        .sidebar .nav-link { color: #cbd5e1; padding: 10px 20px; transition: .2s; border-radius: 6px; margin: 3px 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar .nav-link i { width: 20px; }
        .main-content { margin-left: var(--sidebar-width); padding: 24px; margin-top: 56px; min-height: calc(100vh - 56px); }
        .topbar { height: 56px; margin-left: var(--sidebar-width); }

        /* auth pages full width */
        .auth-page .sidebar, .auth-page .main-content, .auth-page .topbar { margin-left: 0 !important; }
        .auth-page .sidebar { display: none; }
        .auth-page .main-content { padding: 0; margin-top: 0; }
        .auth-page .topbar { display: none; }
    </style>
</head>
<body>