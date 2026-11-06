<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Villa Esmeralda — Manager Panel</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
  :root {
    --sidebar:#0D3B4F;--sidebar-hover:#124A63;--bg:#F3F4F6;--card:#FFFFFF;--text:#1A1A2E;--muted:#6B7280;--border:#E5E7EB;
    --coral:#D4845A;--coral-light:#FDF0E8;--ocean:#1B5C7B;--ocean-light:#E8F4F8;--gold:#C9A96E;--gold-light:#FAF3E6;
    --green:#10B981;--green-light:#D1FAE5;--red:#EF4444;--red-light:#FEE2E2;--blue:#3B82F6;--blue-light:#DBEAFE;
    --radius:10px;--shadow:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);--shadow-md:0 4px 12px rgba(0,0,0,.08);
  }
  *{margin:0;padding:0;box-sizing:border-box}
  body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh}
  .sidebar{width:260px;background:var(--sidebar);color:#fff;display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100;transition:transform .3s}
  .sidebar-brand{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,.1)}
  .sidebar-brand h2{font-family:'Playfair Display',serif;font-size:1.25rem}
  .sidebar-brand h2 span{color:var(--gold)}
  .sidebar-brand .badge{display:inline-block;background:var(--coral);padding:.15rem .6rem;border-radius:100px;font-size:.7rem;font-weight:600;margin-top:.3rem;text-transform:uppercase;letter-spacing:.5px}
  .sidebar-nav{flex:1;padding:1rem 0;overflow-y:auto}
  .sidebar-nav .section{padding:.5rem 1.5rem .3rem;font-size:.7rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);font-weight:600}
  .sidebar-nav a{display:flex;align-items:center;gap:.75rem;padding:.65rem 1.5rem;color:rgba(255,255,255,.75);text-decoration:none;font-size:.88rem;transition:all .15s;border-left:3px solid transparent;cursor:pointer}
  .sidebar-nav a:hover,.sidebar-nav a.active{background:var(--sidebar-hover);color:#fff;border-left-color:var(--gold)}
  .sidebar-nav a .badge-count{margin-left:auto;background:var(--coral);padding:.1rem .55rem;border-radius:100px;font-size:.72rem;font-weight:600}
  .sidebar-footer{padding:1rem 1.5rem;border-top:1px solid rgba(255,255,255,.1);font-size:.82rem;color:rgba(255,255,255,.5)}
  .sidebar-backdrop{display:none}
  .main{margin-left:260px;padding:1.5rem;transition:margin-left .3s}
  .mobile-topbar{display:none;background:#fff;padding:.75rem 1rem;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:90;align-items:center;gap:.75rem}
  .mobile-topbar .hamburger{width:40px;height:40px;border-radius:8px;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:1.3rem;flex-shrink:0}
  .mobile-topbar .brand{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ocean);flex:1}
  .mobile-topbar .brand span{color:var(--coral)}
  .mobile-topbar .quick-btn{width:40px;height:40px;border-radius:8px;border:1.5px solid var(--border);background:var(--coral);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:1.1rem}
  .lang-switch{display:flex;border:1.5px solid var(--border,#e5e7eb);border-radius:8px;overflow:hidden}
  .lang-btn{padding:.4rem .75rem;font-size:.75rem;font-weight:600;cursor:pointer;border:none;background:#fff;color:var(--muted);transition:all .2s;font-family:inherit}
  .lang-btn.active{background:var(--ocean);color:#fff}
  .lang-btn:not(.active):hover{background:#f0f7fa}
  .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem}
  .topbar h1{font-family:'Playfair Display',serif;font-size:1.75rem}
  .topbar-actions{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap}
  .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.2rem;border-radius:8px;font-weight:600;font-size:.85rem;cursor:pointer;border:none;transition:all .2s;text-decoration:none;font-family:inherit;white-space:nowrap}
  .btn-primary{background:var(--coral);color:#fff}.btn-primary:hover{background:#c0734a}
  .btn-outline{border:1.5px solid var(--border);background:#fff;color:var(--text)}.btn-outline:hover{border-color:var(--ocean);color:var(--ocean)}
  .btn-sm{padding:.35rem .8rem;font-size:.78rem}
  .btn-xs{padding:.25rem .55rem;font-size:.7rem}
  .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem}
  .stat-card{background:var(--card);border-radius:var(--radius);padding:1.25rem;box-shadow:var(--shadow);display:flex;align-items:center;gap:1rem;cursor:pointer;transition:transform .15s}
  .stat-card:hover{transform:translateY(-2px)}
  .stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
  .stat-info h3{font-size:1.5rem;font-weight:700}.stat-info p{color:var(--muted);font-size:.8rem;margin-top:.1rem}
  .stat-trend{font-size:.73rem;font-weight:600;margin-top:.2rem}
  .stat-trend.up{color:var(--green)}.stat-trend.down{color:var(--red)}
  .card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden}
  .card-header{padding:1rem 1.25rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem}
  .card-header h3{font-size:.95rem;font-weight:600}
  .card-body{padding:1.25rem}.card-body.no-pad{padding:0}
  .grid-2{display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;margin-bottom:1.25rem}
  .grid-full{margin-bottom:1.25rem}
  .calendar-header{display:grid;grid-template-columns:repeat(7,1fr);text-align:center;font-weight:600;font-size:.75rem;color:var(--muted);padding:.6rem 0;border-bottom:1px solid var(--border)}
  .calendar-grid{display:grid;grid-template-columns:repeat(7,1fr)}
  .calendar-day{aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:.82rem;border-bottom:1px solid var(--border);border-right:1px solid var(--border);cursor:pointer;transition:all .15s;position:relative}
  .calendar-day:nth-child(7n){border-right:none}
  .calendar-day:hover{background:var(--ocean-light)}
  .calendar-day.other-month{color:#ccc}
  .calendar-day.today{background:var(--ocean-light);font-weight:700;color:var(--ocean)}
  .calendar-day.booked{background:var(--coral-light)}
  .calendar-day.booked::after{content:'';position:absolute;bottom:4px;width:5px;height:5px;border-radius:50%;background:var(--coral)}
  .calendar-day.selected{border:2px solid var(--ocean);font-weight:700}
  .table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
  table{width:100%;border-collapse:collapse;min-width:600px}
  th{text-align:left;padding:.7rem 1.25rem;font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;border-bottom:1px solid var(--border);white-space:nowrap}
  td{padding:.8rem 1.25rem;font-size:.85rem;border-bottom:1px solid var(--border)}
  tr{cursor:pointer;transition:background .15s}
  tr:hover td{background:#f9fafb}
  .status{display:inline-block;padding:.25rem .65rem;border-radius:100px;font-size:.73rem;font-weight:600;white-space:nowrap}
  .status.confirmed{background:var(--green-light);color:#059669}
  .status.pending{background:var(--gold-light);color:#92400E}
  .status.in-progress{background:var(--blue-light);color:#2563EB}
  .status.cancelled{background:var(--red-light);color:#DC2626}
  .enquiry-item{padding:.9rem 1.25rem;border-bottom:1px solid var(--border);display:flex;gap:.85rem;cursor:pointer;transition:background .15s}
  .enquiry-item:hover{background:#f9fafb}
  .enquiry-item.unread{border-left:3px solid var(--coral);background:var(--coral-light)}
  .enquiry-item.expanded{background:#f9fafb}
  .enquiry-item.expanded .enquiry-content .msg{white-space:normal!important;overflow:visible!important;text-overflow:unset!important}
  .enquiry-avatar{width:38px;height:38px;border-radius:50%;background:var(--ocean);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:.82rem;flex-shrink:0}
  .enquiry-content{flex:1;min-width:0}
  .enquiry-content .name{font-weight:600;font-size:.85rem}
  .enquiry-content .msg{color:var(--muted);font-size:.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:.1rem;transition:all .3s}
  .enquiry-meta{text-align:right;font-size:.73rem;color:var(--muted);flex-shrink:0;white-space:nowrap}
  .enquiry-reply-bar{display:none;padding:.5rem 1.25rem 1rem;gap:.5rem;background:#f9fafb}
  .enquiry-item.expanded+.enquiry-reply-bar{display:flex}
  .enquiry-reply-bar input{flex:1;padding:.45rem .7rem;border:1.5px solid var(--border);border-radius:8px;font-size:.8rem;font-family:inherit}
  .enquiry-reply-bar button{padding:.45rem 1rem;border-radius:8px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;font-size:.8rem}
  .ai-panel{background:linear-gradient(135deg,var(--sidebar),#0f2b47);color:#fff}
  .ai-panel .card-header{border-color:rgba(255,255,255,.1);color:#fff}
  .ai-chat{padding:1rem;max-height:300px;overflow-y:auto;display:flex;flex-direction:column;gap:.7rem;scroll-behavior:smooth}
  .ai-msg{padding:.6rem .8rem;border-radius:10px;font-size:.8rem;max-width:85%;animation:fadeIn .3s}
  .ai-msg.bot{background:rgba(255,255,255,.12);align-self:flex-start}
  .ai-msg.user{background:var(--coral);align-self:flex-end}
  @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
  .ai-input{display:flex;padding:.7rem;gap:.5rem;border-top:1px solid rgba(255,255,255,.1)}
  .ai-input input{flex:1;padding:.5rem .7rem;border-radius:8px;border:none;background:rgba(255,255,255,.15);color:#fff;font-family:inherit;font-size:.8rem;outline:none;min-width:0}
  .ai-input input::placeholder{color:rgba(255,255,255,.5)}
  .ai-input button{padding:.45rem .9rem;border-radius:8px;border:none;background:var(--gold);color:#fff;font-weight:600;cursor:pointer;font-size:.8rem}
  .quick-actions{display:grid;grid-template-columns:repeat(4,1fr);gap:.85rem}
  .quick-action{background:var(--card);border-radius:var(--radius);padding:1.2rem;text-align:center;cursor:pointer;box-shadow:var(--shadow);transition:all .2s;border:1.5px solid transparent}
  .quick-action:hover{border-color:var(--ocean);transform:translateY(-2px);box-shadow:var(--shadow-md)}
  .quick-action .icon{font-size:1.4rem;margin-bottom:.4rem}
  .quick-action .label{font-size:.8rem;font-weight:600}
  .bottom-nav{display:none;position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:1px solid var(--border);z-index:95;padding:.5rem .5rem env(safe-area-inset-bottom,.5rem)}
  .bottom-nav-inner{display:flex;justify-content:space-around}
  .bottom-nav a{display:flex;flex-direction:column;align-items:center;gap:.2rem;text-decoration:none;color:var(--muted);font-size:.65rem;font-weight:500;padding:.4rem .3rem;transition:color .15s;cursor:pointer}
  .bottom-nav a.active{color:var(--coral)}
  .bottom-nav a .nav-icon{font-size:1.2rem}

  /* MODAL */
  .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;align-items:center;justify-content:center;padding:1rem}
  .modal-overlay.show{display:flex}
  .modal{background:#fff;border-radius:var(--radius);box-shadow:0 20px 60px rgba(0,0,0,.3);max-width:520px;width:100%;max-height:90vh;overflow-y:auto;animation:slideUp .25s}
  @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
  .modal-header{padding:1.25rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
  .modal-header h3{font-weight:700;font-size:1.1rem}
  .modal-close{width:36px;height:36px;border-radius:8px;border:1.5px solid var(--border);background:#fff;cursor:pointer;font-size:1.2rem;display:flex;align-items:center;justify-content:center}
  .modal-body{padding:1.25rem}
  .modal-body .detail-row{display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--border);font-size:.88rem}
  .modal-body .detail-row:last-child{border-bottom:none}
  .modal-body .detail-row .lbl{color:var(--muted)}
  .modal-body .detail-row .val{font-weight:600}

  /* TOAST */
  .toast{position:fixed;bottom:2rem;left:50%;transform:translateX(-50%);background:var(--sidebar);color:#fff;padding:.75rem 1.5rem;border-radius:100px;font-size:.85rem;font-weight:600;z-index:300;animation:toastIn .3s,toastOut .3s 2.5s forwards;box-shadow:0 8px 30px rgba(0,0,0,.25);pointer-events:none}
  @keyframes toastIn{from{opacity:0;transform:translateX(-50%) translateY(10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}
  @keyframes toastOut{from{opacity:1}to{opacity:0;transform:translateX(-50%) translateY(-10px)}}

  @media(max-width:1024px){
    .grid-2{grid-template-columns:1fr}
    .quick-actions{grid-template-columns:repeat(2,1fr)}
    .sidebar{width:220px}.main{margin-left:220px}
    .topbar h1{font-size:1.4rem}
  }
  @media(max-width:768px){
    .sidebar{transform:translateX(-100%);width:280px}
    .sidebar.open{transform:translateX(0)}
    .sidebar-backdrop{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:99}
    .sidebar-backdrop.show{display:block}
    .mobile-topbar{display:flex}
    .main{margin-left:0;padding:1rem;padding-bottom:5rem}
    .topbar{flex-direction:column;align-items:flex-start}
    .topbar h1{font-size:1.3rem}
    .topbar-actions{width:100%}
    .topbar-actions .btn{flex:1;justify-content:center}
    .stats-grid{grid-template-columns:repeat(2,1fr);gap:.75rem}
    .stat-card{padding:1rem;gap:.7rem}
    .stat-icon{width:38px;height:38px;border-radius:10px;font-size:1.1rem}
    .stat-info h3{font-size:1.25rem}.stat-info p{font-size:.72rem}
    .calendar-day{font-size:.72rem}.calendar-header{font-size:.68rem}
    th,td{padding:.6rem .8rem;font-size:.78rem}
    .enquiry-item{padding:.75rem 1rem}
    .enquiry-avatar{width:34px;height:34px;font-size:.75rem}
    .ai-chat{max-height:220px;gap:.5rem}
    .ai-msg{font-size:.75rem;padding:.5rem .7rem;max-width:90%}
    .quick-actions{grid-template-columns:repeat(2,1fr);gap:.6rem}
    .quick-action{padding:.9rem}.quick-action .icon{font-size:1.2rem}.quick-action .label{font-size:.73rem}
    .card-header{padding:.85rem 1rem}.card-header h3{font-size:.88rem}
    .card-body{padding:1rem}
    .bottom-nav{display:block}
    .btn{padding:.5rem 1rem;font-size:.8rem}.btn-sm{padding:.35rem .7rem;font-size:.73rem}
    .modal{max-width:95vw;max-height:85vh}
  }
  @media(max-width:400px){
    .stats-grid{grid-template-columns:1fr 1fr;gap:.5rem}
    .stat-card{padding:.75rem;flex-direction:column;align-items:flex-start;gap:.4rem}
    .stat-icon{width:34px;height:34px;font-size:1rem}
    .calendar-day{font-size:.65rem}
    .topbar h1{font-size:1.2rem}
  }
</style>
</head>
<body>

<!-- Mobile Topbar -->
<div class="mobile-topbar">
  <button class="hamburger" onclick="toggleSidebar()" aria-label="Menu">☰</button>
  <div class="brand">Villa <span>Esmeralda</span></div>
  <div class="lang-switch">
    <button class="lang-btn active" onclick="setLang('de')">DE</button>
    <button class="lang-btn" onclick="setLang('en')">EN</button>
  </div>
  <button class="quick-btn" onclick="openModal('bookingModal')" aria-label="New booking">+</button>
  <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline btn-sm" type="submit">Logout</button></form>
</div>

<div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <h2>Villa <span>Esmeralda</span></h2>
    <div class="badge" data-i18n="sidebar.badge">Manager Panel</div>
  </div>
  <nav class="sidebar-nav">
    <div class="section" data-i18n="sidebar.main">Hauptmenü</div>
    <a href="#" class="active" onclick="navTo('dashboard');closeSidebar()">📊 <span data-i18n="nav.dashboard">Dashboard</span></a>
    <a href="#" onclick="navTo('calendar');closeSidebar()">📅 <span data-i18n="nav.calendar">Kalender</span></a>
    <a href="#" onclick="navTo('bookings');closeSidebar()">🛏️ <span data-i18n="nav.bookings">Buchungen</span><span class="badge-count">3</span></a>
    <a href="#" onclick="navTo('enquiries');closeSidebar()">💬 <span data-i18n="nav.enquiries">Anfragen</span><span class="badge-count">5</span></a>
    <div class="section" data-i18n="sidebar.admin">Verwaltung</div>
    <a href="#" onclick="navTo('guests');closeSidebar()">👥 <span data-i18n="nav.guests">Gästeliste</span></a>
    <a href="#" onclick="navTo('payments');closeSidebar()">💳 <span data-i18n="nav.payments">Zahlungen</span></a>
    <a href="#" onclick="navTo('gallery');closeSidebar()">📸 <span data-i18n="nav.gallery">Galerie</span></a>
    <a href="#" onclick="navTo('settings');closeSidebar()">⚙️ <span data-i18n="nav.settings">Einstellungen</span></a>
    <div class="section" data-i18n="sidebar.ai">KI-Tools</div>
    <a href="#" onclick="navTo('ai');closeSidebar()">🤖 <span data-i18n="nav.ai">KI-Assistent</span></a>
    <a href="#" onclick="navTo('analytics');closeSidebar()">📈 <span data-i18n="nav.analytics">Analysen</span></a>
    <a href="#" onclick="navTo('automation');closeSidebar()">✉️ <span data-i18n="nav.automation">Automatisierung</span></a>
  </nav>
  <div class="sidebar-footer">
    <div>👤 Villa Esmeralda Admin</div>
    <div style="font-size:.72rem;opacity:.7;">Costa Calma · Fuerteventura</div>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline btn-sm" type="submit">Logout</button></form>
  </div>
</aside>

<!-- Main Content -->
<main class="main">
  <div class="topbar">
    <div>
      <h1 data-i18n="dashboard.title">Dashboard</h1>
      <p style="color:var(--muted);font-size:.85rem;" data-i18n="dashboard.sub">Willkommen zurück! Hier ist Ihre Übersicht für heute.</p>
      <p role="status">Demo: Beispieldaten, keine echten Aktionen. / Sample data; no real actions.</p>
    </div>
    <div class="topbar-actions">
      <div class="lang-switch">
        <button class="lang-btn active" onclick="setLang('de')">DE</button>
        <button class="lang-btn" onclick="setLang('en')">EN</button>
      </div>
      <button class="btn btn-outline btn-sm" onclick="demoNotice()">📥 <span data-i18n="actions.export">Export</span></button>
      <button class="btn btn-primary" onclick="openModal('bookingModal')">+ <span data-i18n="actions.newBooking">Neue Buchung</span></button>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card" onclick="navTo('bookings')">
      <div class="stat-icon" style="background:var(--ocean-light);color:var(--ocean)">🛏️</div>
      <div class="stat-info"><h3>12</h3><p data-i18n="stats.active">Aktive Buchungen</p><div class="stat-trend up" data-i18n="stats.activeTrend">↑ 18% vs. Vormonat</div></div>
    </div>
    <div class="stat-card" onclick="navTo('payments')">
      <div class="stat-icon" style="background:var(--coral-light);color:var(--coral)">💰</div>
      <div class="stat-info"><h3>€4.850</h3><p data-i18n="stats.revenue">Umsatz diesen Monat</p><div class="stat-trend up" data-i18n="stats.revenueTrend">↑ 12% vs. Vormonat</div></div>
    </div>
    <div class="stat-card" onclick="navTo('guests')">
      <div class="stat-icon" style="background:var(--gold-light);color:var(--gold)">👥</div>
      <div class="stat-info"><h3>28</h3><p data-i18n="stats.guests">Gäste im Haus</p><div class="stat-trend up" data-i18n="stats.guestsTrend">↑ 5 heute</div></div>
    </div>
    <div class="stat-card" onclick="navTo('enquiries')">
      <div class="stat-icon" style="background:var(--blue-light);color:var(--blue)">💬</div>
      <div class="stat-info"><h3>5</h3><p data-i18n="stats.enquiries">Neue Anfragen</p><div class="stat-trend down" data-i18n="stats.enquiriesTrend">↓ 2 vs. gestern</div></div>
    </div>
  </div>

  <!-- Calendar + Enquiries -->
  <div class="grid-2">
    <div class="card">
      <div class="card-header">
        <h3 id="calTitle">📅 <span data-i18n="calendar.august">August 2026</span></h3>
        <div style="display:flex;gap:.4rem">
          <button class="btn btn-outline btn-sm" onclick="navCal(-1)">←</button>
          <button class="btn btn-outline btn-sm" onclick="navCal(0)" data-i18n="calendar.today">Heute</button>
          <button class="btn btn-outline btn-sm" onclick="navCal(1)">→</button>
        </div>
      </div>
      <div class="card-body no-pad">
        <div class="calendar-header"><span>Mo</span><span>Di</span><span>Mi</span><span>Do</span><span>Fr</span><span>Sa</span><span>So</span></div>
        <div class="calendar-grid" id="calGrid"></div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3>💬 <span data-i18n="enquiries.title">Neue Anfragen</span></h3><button class="btn btn-outline btn-sm" data-i18n="enquiries.all">Alle →</button></div>
      <div class="card-body no-pad" id="enquiryList"></div>
    </div>
  </div>

  <!-- Bookings + AI -->
  <div class="grid-2">
    <div class="card">
      <div class="card-header"><h3>🛏️ <span data-i18n="bookings.title">Aktuelle Buchungen</span></h3><button class="btn btn-outline btn-sm" data-i18n="bookings.all">Alle →</button></div>
      <div class="card-body no-pad"><div class="table-wrap"><table><thead><tr><th data-i18n="table.guest">Gast</th><th data-i18n="table.room">Zimmer</th><th data-i18n="table.checkin">Check-in</th><th data-i18n="table.checkout">Check-out</th><th data-i18n="table.amount">Betrag</th><th data-i18n="table.status">Status</th></tr></thead><tbody id="bookingsBody"></tbody></table></div></div>
    </div>

    <div class="card ai-panel">
      <div class="card-header"><h3>🤖 <span data-i18n="ai.title">KI-Assistent</span></h3><span style="font-size:.75rem;opacity:.7" data-i18n="ai.ready">Immer bereit</span></div>
      <div class="ai-chat" id="aiChat"></div>
      <div class="ai-input">
        <input type="text" id="aiInput" placeholder="Fragen Sie den KI-Assistenten..." onkeydown="if(event.key==='Enter')sendAI()">
        <button onclick="sendAI()" data-i18n="ai.send">Senden</button>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="grid-full"><div class="quick-actions">
    <div class="quick-action" onclick="openModal('bookingModal')"><div class="icon">📅</div><div class="label" data-i18n="actions.booking">Buchung anlegen</div></div>
    <div class="quick-action" onclick="openModal('paymentModal')"><div class="icon">💳</div><div class="label" data-i18n="actions.payment">Zahlung erfassen</div></div>
    <div class="quick-action" onclick="openModal('messageModal')"><div class="icon">✉️</div><div class="label" data-i18n="actions.message">Gast anschreiben</div></div>
    <div class="quick-action" onclick="demoNotice()"><div class="icon">📊</div><div class="label" data-i18n="actions.report">Bericht erstellen</div></div>
  </div></div>

  <!-- Payments -->
  <div class="grid-full"><div class="card">
    <div class="card-header"><h3>💳 <span data-i18n="payments.title">Zahlungsübersicht — August 2026</span></h3><button class="btn btn-outline btn-sm" data-i18n="payments.all">Alle →</button></div>
    <div class="card-body no-pad"><div class="table-wrap"><table><thead><tr><th data-i18n="table.bookingNr">Buchung #</th><th data-i18n="table.guest">Gast</th><th data-i18n="table.amount">Betrag</th><th data-i18n="table.method">Methode</th><th data-i18n="table.date">Datum</th><th data-i18n="table.status">Status</th><th data-i18n="table.action">Aktion</th></tr></thead><tbody id="paymentsBody"></tbody></table></div></div>
  </div></div>
</main>

<!-- Bottom Nav -->
<nav class="bottom-nav"><div class="bottom-nav-inner">
  <a href="#" class="active" onclick="navTo('dashboard')"><span class="nav-icon">📊</span>Dashboard</a>
  <a href="#" onclick="navTo('calendar')"><span class="nav-icon">📅</span>Kalender</a>
  <a href="#" onclick="navTo('bookings')"><span class="nav-icon">🛏️</span>Buchungen</a>
  <a href="#" onclick="navTo('enquiries')"><span class="nav-icon">💬</span>Anfragen</a>
  <a href="#" onclick="navTo('payments')"><span class="nav-icon">⚙️</span>Mehr</a>
</div></nav>

<!-- MODALS -->
<div class="modal-overlay" id="bookingModal"><div class="modal">
  <div class="modal-header"><h3 data-i18n="modal.bookingTitle">📅 Neue Buchung anlegen</h3><button class="modal-close" onclick="closeModal('bookingModal')">✕</button></div>
  <div class="modal-body">
    <div class="form-group" style="margin-bottom:.8rem"><label data-i18n="modal.guestName" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Gastname</label><input type="text" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit" placeholder="Max Mustermann"></div>
    <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-bottom:.8rem">
      <div><label data-i18n="modal.checkin" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Check-in</label><input type="date" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit"></div>
      <div><label data-i18n="modal.checkout" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Check-out</label><input type="date" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit"></div>
    </div>
    <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-bottom:.8rem">
      <div><label data-i18n="modal.guests" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Gäste</label><select class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit"><option>2 Erwachsene</option><option>1 Erwachsener</option><option>3 Erwachsene</option><option>4 Erwachsene</option></select></div>
      <div><label data-i18n="modal.roomType" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Zimmertyp</label><select class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit"><option>Master Suite (€180/Nacht)</option><option>Junior Suite (€130/Nacht)</option><option>Gesamte Villa (€380/Nacht)</option></select></div>
    </div>
    <button class="btn btn-primary" style="width:100%;margin-top:.5rem;padding:.7rem" onclick="closeModal('bookingModal');demoNotice()"><span data-i18n="modal.createBooking">Buchung anlegen</span></button>
  </div>
</div></div>

<div class="modal-overlay" id="paymentModal"><div class="modal">
  <div class="modal-header"><h3 data-i18n="modal.paymentTitle">💳 Zahlung erfassen</h3><button class="modal-close" onclick="closeModal('paymentModal')">✕</button></div>
  <div class="modal-body">
    <div class="form-group" style="margin-bottom:.8rem"><label data-i18n="modal.bookingRef" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Buchungsreferenz</label><input type="text" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit" placeholder="#10XX"></div>
    <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-bottom:.8rem">
      <div><label data-i18n="modal.amount" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Betrag (€)</label><input type="number" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit" placeholder="0.00"></div>
      <div><label data-i18n="modal.method" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Methode</label><select class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit"><option>💳 Kreditkarte</option><option>🏦 SEPA</option><option>💵 Bar</option></select></div>
    </div>
    <button class="btn btn-primary" style="width:100%;margin-top:.5rem;padding:.7rem" onclick="closeModal('paymentModal');demoNotice()"><span data-i18n="modal.capturePayment">Zahlung erfassen</span></button>
  </div>
</div></div>

<div class="modal-overlay" id="messageModal"><div class="modal">
  <div class="modal-header"><h3 data-i18n="modal.messageTitle">✉️ Gast anschreiben</h3><button class="modal-close" onclick="closeModal('messageModal')">✕</button></div>
  <div class="modal-body">
    <div class="form-group" style="margin-bottom:.8rem"><label data-i18n="modal.recipient" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Empfänger</label><input type="text" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit" placeholder="gast@email.com"></div>
    <div class="form-group" style="margin-bottom:.8rem"><label data-i18n="modal.subject" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Betreff</label><input type="text" class="form-input" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit" placeholder="Ihr Aufenthalt in der Villa Esmeralda"></div>
    <div class="form-group" style="margin-bottom:.8rem"><label data-i18n="modal.message" style="display:block;font-weight:600;font-size:.82rem;margin-bottom:.3rem">Nachricht</label><textarea class="form-input" rows="3" style="width:100%;padding:.6rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;resize:vertical"></textarea></div>
    <button class="btn btn-primary" style="width:100%;margin-top:.5rem;padding:.7rem" onclick="closeModal('messageModal');demoNotice()"><span data-i18n="modal.sendMessage">Nachricht senden</span></button>
  </div>
</div></div>

<div class="modal-overlay" id="detailModal"><div class="modal"><div class="modal-header"><h3 id="detailTitle">🛏️ Buchungsdetails</h3><button class="modal-close" onclick="closeModal('detailModal')">✕</button></div><div class="modal-body" id="detailBody"></div></div></div>

<div class="modal-overlay" id="receiptModal"><div class="modal"><div class="modal-header"><h3>🧾 Quittung</h3><button class="modal-close" onclick="closeModal('receiptModal')">✕</button></div><div class="modal-body"><p>Demo: Keine Quittung versendet. / No receipt was sent.</p></div></div></div>

<script>
/* ════════ I18N ════════ */
const langData={de:{
  'sidebar.badge':'Manager Panel','sidebar.main':'Hauptmenü','sidebar.admin':'Verwaltung','sidebar.ai':'KI-Tools',
  'nav.dashboard':'Dashboard','nav.calendar':'Kalender','nav.bookings':'Buchungen','nav.enquiries':'Anfragen','nav.guests':'Gästeliste','nav.payments':'Zahlungen','nav.gallery':'Galerie','nav.settings':'Einstellungen','nav.ai':'KI-Assistent','nav.analytics':'Analysen','nav.automation':'Automatisierung',
  'dashboard.title':'Dashboard','dashboard.sub':'Willkommen zurück! Hier ist Ihre Übersicht für heute.',
  'stats.active':'Aktive Buchungen','stats.activeTrend':'↑ 18% vs. Vormonat','stats.revenue':'Umsatz diesen Monat','stats.revenueTrend':'↑ 12% vs. Vormonat','stats.guests':'Gäste im Haus','stats.guestsTrend':'↑ 5 heute','stats.enquiries':'Neue Anfragen','stats.enquiriesTrend':'↓ 2 vs. gestern',
  'calendar.august':'August 2026','calendar.today':'Heute',
  'enquiries.title':'Neue Anfragen','enquiries.all':'Alle →',
  'bookings.title':'Aktuelle Buchungen','bookings.all':'Alle →',
  'table.guest':'Gast','table.room':'Zimmer','table.checkin':'Check-in','table.checkout':'Check-out','table.amount':'Betrag','table.status':'Status','table.bookingNr':'Buchung #','table.method':'Methode','table.date':'Datum','table.action':'Aktion',
  'ai.title':'KI-Assistent','ai.ready':'Immer bereit','ai.send':'Senden',
  'actions.export':'Export','actions.newBooking':'Neue Buchung','actions.booking':'Buchung anlegen','actions.payment':'Zahlung erfassen','actions.message':'Gast anschreiben','actions.report':'Bericht erstellen',
  'payments.title':'Zahlungsübersicht — August 2026','payments.all':'Alle →',
  'modal.bookingTitle':'📅 Neue Buchung anlegen','modal.guestName':'Gastname','modal.checkin':'Check-in','modal.checkout':'Check-out','modal.guests':'Gäste','modal.roomType':'Zimmertyp','modal.createBooking':'Buchung anlegen',
  'modal.paymentTitle':'💳 Zahlung erfassen','modal.bookingRef':'Buchungsreferenz','modal.amount':'Betrag (€)','modal.method':'Methode','modal.capturePayment':'Zahlung erfassen',
  'modal.messageTitle':'✉️ Gast anschreiben','modal.recipient':'Empfänger','modal.subject':'Betreff','modal.message':'Nachricht','modal.sendMessage':'Nachricht senden',
  'receipt.sent':'Quittung wurde an den Gast gesendet'
},en:{
  'sidebar.badge':'Manager Panel','sidebar.main':'Main Menu','sidebar.admin':'Management','sidebar.ai':'AI Tools',
  'nav.dashboard':'Dashboard','nav.calendar':'Calendar','nav.bookings':'Bookings','nav.enquiries':'Enquiries','nav.guests':'Guest List','nav.payments':'Payments','nav.gallery':'Gallery','nav.settings':'Settings','nav.ai':'AI Assistant','nav.analytics':'Analytics','nav.automation':'Automation',
  'dashboard.title':'Dashboard','dashboard.sub':'Welcome back! Here\'s your overview for today.',
  'stats.active':'Active Bookings','stats.activeTrend':'↑ 18% vs. last month','stats.revenue':'Revenue this month','stats.revenueTrend':'↑ 12% vs. last month','stats.guests':'Guests in-house','stats.guestsTrend':'↑ 5 today','stats.enquiries':'New Enquiries','stats.enquiriesTrend':'↓ 2 vs. yesterday',
  'calendar.august':'August 2026','calendar.today':'Today',
  'enquiries.title':'New Enquiries','enquiries.all':'All →',
  'bookings.title':'Recent Bookings','bookings.all':'All →',
  'table.guest':'Guest','table.room':'Room','table.checkin':'Check-in','table.checkout':'Check-out','table.amount':'Amount','table.status':'Status','table.bookingNr':'Booking #','table.method':'Method','table.date':'Date','table.action':'Action',
  'ai.title':'AI Assistant','ai.ready':'Always ready','ai.send':'Send',
  'actions.export':'Export','actions.newBooking':'New Booking','actions.booking':'New Booking','actions.payment':'Record Payment','actions.message':'Message Guest','actions.report':'Generate Report',
  'payments.title':'Payment Overview — August 2026','payments.all':'All →',
  'modal.bookingTitle':'📅 New Booking','modal.guestName':'Guest Name','modal.checkin':'Check-in','modal.checkout':'Check-out','modal.guests':'Guests','modal.roomType':'Room Type','modal.createBooking':'Create Booking',
  'modal.paymentTitle':'💳 Record Payment','modal.bookingRef':'Booking Reference','modal.amount':'Amount (€)','modal.method':'Method','modal.capturePayment':'Record Payment',
  'modal.messageTitle':'✉️ Message Guest','modal.recipient':'Recipient','modal.subject':'Subject','modal.message':'Message','modal.sendMessage':'Send Message',
  'receipt.sent':'Receipt has been sent to the guest'
}};
let curLang='de';
function setLang(l){curLang=l;document.querySelectorAll('.lang-btn').forEach(b=>b.classList.toggle('active',b.textContent.trim().toLowerCase()===l));document.querySelectorAll('[data-i18n]').forEach(el=>{const k=el.dataset.i18n;if(langData[l]&&langData[l][k])el.textContent=langData[l][k]});localStorage.setItem('ve-lang',l)}
function t(key){return langData[curLang]&&langData[curLang][key]||key}

/* ════════ CALENDAR ════════ */
const monthsDE=['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'];
const monthsEN=['January','February','March','April','May','June','July','August','September','October','November','December'];
let calYear=2026,calMonth=7;
const bookedDays={7:[11,12,13,14,24,25,26,27,28]};

function renderCal(){
  const grid=document.getElementById('calGrid');
  const title=document.getElementById('calTitle');
  const mn=curLang==='en'?monthsEN:monthsDE;
  title.innerHTML='📅 '+mn[calMonth]+' '+calYear;
  const firstDay=new Date(calYear,calMonth,1).getDay();
  const offset=(firstDay+6)%7;
  const daysInMonth=new Date(calYear,calMonth+1,0).getDate();
  const today=new Date();const tY=today.getFullYear(),tM=today.getMonth(),tD=today.getDate();
  let html='';
  for(let i=0;i<offset;i++)html+='<span class="calendar-day other-month"></span>';
  for(let d=1;d<=daysInMonth;d++){
    let cls='calendar-day';
    if(calYear===tY&&calMonth===tM&&d===tD)cls+=' today';
    if(bookedDays[calMonth]&&bookedDays[calMonth].includes(d))cls+=' booked';
    html+='<span class="'+cls+'" onclick="calDayClick('+d+')">'+d+'</span>';
  }
  grid.innerHTML=html;
}
function navCal(dir){
  if(dir===0){const now=new Date();calYear=now.getFullYear();calMonth=now.getMonth();}
  else{calMonth+=dir;if(calMonth<0){calMonth=11;calYear--}else if(calMonth>11){calMonth=0;calYear++}}
  renderCal();
}
function calDayClick(d){
  document.querySelectorAll('.calendar-day.selected').forEach(e=>e.classList.remove('selected'));
  const days=document.querySelectorAll('.calendar-day:not(.other-month)');
  const selected=Array.from(days).find(el=>el.textContent==d&&!el.classList.contains('selected'));
  if(selected){selected.classList.add('selected');toast('📅 '+d+'. '+(curLang==='en'?monthsEN[calMonth]:monthsDE[calMonth])+' — '+(bookedDays[calMonth]&&bookedDays[calMonth].includes(d)?(curLang==='en'?'Booked':'Belegt'):(curLang==='en'?'Available':'Verfügbar')))}
}
renderCal();

/* ════════ ENQUIRIES ════════ */
const enquiriesDE=[
  {initials:'MS',name:'Markus Schuster',msg:'Gibt es einen privaten Parkplatz? Wir kommen mit Mietwagen...',time:'vor 2 Std',unread:true,color:''},
  {initials:'EL',name:'Elena Lombardi',msg:'Können wir früher einchecken? Unser Flug landet um 10:30...',time:'vor 5 Std',unread:true,color:'var(--coral)'},
  {initials:'JK',name:'Jan Kowalski',msg:'Ist die Villa kinderfreundlich? Wir haben 2 Kinder (3 & 6)...',time:'gestern',unread:false,color:'var(--gold)'},
  {initials:'SB',name:'Sandra Baumgart',msg:'Danke für den tollen Aufenthalt! Wir kommen nächstes Jahr wieder.',time:'2. Aug',unread:false,color:'var(--green)'}
];
const enquiriesEN=[
  {initials:'MS',name:'Markus Schuster',msg:'Is there private parking? We\'re coming with a rental car...',time:'2h ago',unread:true,color:''},
  {initials:'EL',name:'Elena Lombardi',msg:'Can we check in earlier? Our flight lands at 10:30...',time:'5h ago',unread:true,color:'var(--coral)'},
  {initials:'JK',name:'Jan Kowalski',msg:'Is the villa child-friendly? We have 2 kids (3 & 6)...',time:'yesterday',unread:false,color:'var(--gold)'},
  {initials:'SB',name:'Sandra Baumgart',msg:'Thank you for the wonderful stay! We\'ll be back next year.',time:'Aug 2',unread:false,color:'var(--green)'}
];
function renderEnquiries(){
  const list=document.getElementById('enquiryList');
  const data=curLang==='en'?enquiriesEN:enquiriesDE;
  const isEn=curLang==='en';
  let html='';
  data.forEach((e,i)=>{
    const metaTime=e.time.includes('Std')||e.time.includes('h ')?e.time:e.time+' '+(e.time.includes('vor')||e.time.includes('yesterday')?'':(isEn?'':'vor '));
    const replyPlaceholder=isEn?'Reply...':'Antworten...';
    const replyBtn=isEn?'Reply':'Senden';
    const replyToast=isEn?'Demo only: no message sent.':'Nur Demo: Keine Nachricht gesendet.';
    html+='<div class="enquiry-item'+(e.unread?' unread':'')+'" id="enq'+i+'" onclick="toggleEnquiry('+i+')">';
    html+='<div class="enquiry-avatar" style="'+(e.color?'background:'+e.color:'')+'">'+e.initials+'</div>';
    html+='<div class="enquiry-content"><div class="name">'+e.name+'</div><div class="msg">'+e.msg+'</div></div>';
    html+='<div class="enquiry-meta">'+metaTime+'</div></div>';
    html+='<div class="enquiry-reply-bar"><input placeholder="'+replyPlaceholder+'"><button onclick="event.stopPropagation();toast(\'&#9993;&#65039; '+replyToast+'\')">'+replyBtn+'</button></div>';
  });
  list.innerHTML=html;
}
function toggleEnquiry(i){
  const el=document.getElementById('enq'+i);
  el.classList.toggle('expanded');
  if(el.classList.contains('unread')){el.classList.remove('unread')}
}
renderEnquiries();

/* ════════ BOOKINGS TABLE ════════ */
const bookingsDE=[
  {guest:'Familie Müller',room:'Master Suite',checkin:'11. Aug',checkout:'18. Aug',amount:'€1.260',status:'confirmed',statusLbl:'Bestätigt'},
  {guest:'Elena Lombardi',room:'Junior Suite',checkin:'24. Aug',checkout:'28. Aug',amount:'€520',status:'pending',statusLbl:'Ausstehend'},
  {guest:'John & Sarah',room:'Gesamte Villa',checkin:'15. Aug',checkout:'22. Aug',amount:'€2.660',status:'in-progress',statusLbl:'Im Aufenthalt'},
  {guest:'Herr Weber',room:'Master Suite',checkin:'28. Jul',checkout:'4. Aug',amount:'€1.080',status:'confirmed',statusLbl:'Bestätigt'},
  {guest:'Gruppe Schmidt',room:'Gesamte Villa',checkin:'5. Sep',checkout:'12. Sep',amount:'€2.660',status:'pending',statusLbl:'Ausstehend'}
];
const bookingsEN=[
  {guest:'Müller Family',room:'Master Suite',checkin:'Aug 11',checkout:'Aug 18',amount:'€1,260',status:'confirmed',statusLbl:'Confirmed'},
  {guest:'Elena Lombardi',room:'Junior Suite',checkin:'Aug 24',checkout:'Aug 28',amount:'€520',status:'pending',statusLbl:'Pending'},
  {guest:'John & Sarah',room:'Entire Villa',checkin:'Aug 15',checkout:'Aug 22',amount:'€2,660',status:'in-progress',statusLbl:'In Progress'},
  {guest:'Mr. Weber',room:'Master Suite',checkin:'Jul 28',checkout:'Aug 4',amount:'€1,080',status:'confirmed',statusLbl:'Confirmed'},
  {guest:'Schmidt Group',room:'Entire Villa',checkin:'Sep 5',checkout:'Sep 12',amount:'€2,660',status:'pending',statusLbl:'Pending'}
];
function renderBookings(){
  document.getElementById('bookingsBody').innerHTML=(curLang==='en'?bookingsEN:bookingsDE).map((b,i)=>'<tr onclick="showBookingDetail('+i+')"><td><strong>'+b.guest+'</strong></td><td>'+b.room+'</td><td>'+b.checkin+'</td><td>'+b.checkout+'</td><td>'+b.amount+'</td><td><span class="status '+b.status+'">'+b.statusLbl+'</span></td></tr>').join('');
}
function showBookingDetail(i){
  const b=(curLang==='en'?bookingsEN:bookingsDE)[i];
  document.getElementById('detailTitle').innerHTML='🛏️ '+(curLang==='en'?'Booking Details':'Buchungsdetails');
  document.getElementById('detailBody').innerHTML='<div class="detail-row"><span class="lbl">'+(curLang==='en'?'Guest':'Gast')+'</span><span class="val">'+b.guest+'</span></div><div class="detail-row"><span class="lbl">'+(curLang==='en'?'Room':'Zimmer')+'</span><span class="val">'+b.room+'</span></div><div class="detail-row"><span class="lbl">'+(curLang==='en'?'Check-in':'Check-in')+'</span><span class="val">'+b.checkin+'</span></div><div class="detail-row"><span class="lbl">'+(curLang==='en'?'Check-out':'Check-out')+'</span><span class="val">'+b.checkout+'</span></div><div class="detail-row"><span class="lbl">'+(curLang==='en'?'Amount':'Betrag')+'</span><span class="val">'+b.amount+'</span></div><div class="detail-row"><span class="lbl">'+(curLang==='en'?'Status':'Status')+'</span><span class="val"><span class="status '+b.status+'">'+b.statusLbl+'</span></span></div>';
  openModal('detailModal');
}
renderBookings();

/* ════════ PAYMENTS TABLE ════════ */
const paymentsDE=[
  {nr:'#1042',guest:'Familie Müller',amount:'€1.260',method:'💳 Visa •••4242',date:'5. Aug',status:'confirmed',statusLbl:'Bezahlt',action:'receipt'},
  {nr:'#1043',guest:'Elena Lombardi',amount:'€520',method:'🏦 SEPA',date:'—',status:'pending',statusLbl:'Ausstehend',action:'remind'},
  {nr:'#1044',guest:'John & Sarah',amount:'€2.660',method:'💳 MC •••8976',date:'10. Aug',status:'confirmed',statusLbl:'Bezahlt',action:'receipt'},
  {nr:'#1045',guest:'Gruppe Schmidt',amount:'€798',method:'💳 Amex •••1033',date:'—',status:'pending',statusLbl:'Ausstehend',action:'remind'}
];
const paymentsEN=[
  {nr:'#1042',guest:'Müller Family',amount:'€1,260',method:'💳 Visa •••4242',date:'Aug 5',status:'confirmed',statusLbl:'Paid',action:'receipt'},
  {nr:'#1043',guest:'Elena Lombardi',amount:'€520',method:'🏦 SEPA',date:'—',status:'pending',statusLbl:'Pending',action:'remind'},
  {nr:'#1044',guest:'John & Sarah',amount:'€2,660',method:'💳 MC •••8976',date:'Aug 10',status:'confirmed',statusLbl:'Paid',action:'receipt'},
  {nr:'#1045',guest:'Schmidt Group',amount:'€798',method:'💳 Amex •••1033',date:'—',status:'pending',statusLbl:'Pending',action:'remind'}
];
function renderPayments(){
  const data=curLang==='en'?paymentsEN:paymentsDE;
  const isEn=curLang==='en';
  let html='';
  data.forEach(p=>{
    const btnClass=p.action==='remind'?'btn-primary':'btn-outline';
    const btnLabel=p.action==='remind'?(isEn?'Remind':'Erinnern'):(isEn?'Receipt':'Quittung');
    const onclick=p.action==='remind'?'toastClick(this)' : 'openModalClick(this)';
    html+='<tr><td>'+p.nr+'</td><td>'+p.guest+'</td><td><strong>'+p.amount+'</strong></td><td>'+p.method+'</td><td>'+p.date+'</td>';
    html+='<td><span class="status '+p.status+'">'+p.statusLbl+'</span></td>';
    html+='<td><button class="btn '+btnClass+' btn-xs" data-action="'+p.action+'" onclick="event.stopPropagation();'+onclick+'">'+btnLabel+'</button></td></tr>';
  });
  document.getElementById('paymentsBody').innerHTML=html;
}
renderPayments();

/* ════════ AI CHAT ════════ */
const aiResponses={de:[
  {q:['hallo','hi','guten morgen','guten tag'],a:'Guten Tag! 👋 Wie kann ich Ihnen heute helfen? Ich kann Buchungen prüfen, Verfügbarkeiten checken oder Gäste erinnern.'},
  {q:['buchung','verfügbar','verfügbarkeit','frei'],a:'Die Villa ist nächste Woche noch verfügbar — vom 28. Juli bis 3. August. Soll ich eine Buchung anlegen?'},
  {q:['gast','gäste','erinnern','check-in'],a:'Sie haben aktuell 2 bevorstehende Check-ins: 11. August (Familie Müller) und 24. August (Elena Lombardi). Soll ich beide erinnern?'},
  {q:['zahlung','bezahlt','ausstehend'],a:'2 Zahlungen sind noch ausstehend: Elena Lombardi (€520) und Gruppe Schmidt (€798). Soll ich eine Zahlungserinnerung senden?'},
  {q:['umsatz','monat','einnahmen'],a:'Diesen Monat: €4.850 Umsatz aus 12 Buchungen. Das ist ein Plus von 12% zum Vormonat. Die gesamte Villa bringt 58% des Umsatzes.'},
  {q:['bericht','report','analyse'],a:'August-Prognose: 15 Buchungen erwartet, ~€6.000 Umsatz. Beste Woche: 18.-24. August mit 5 Buchungen. Soll ich den Monatsbericht erstellen?'},
  {q:['danke','super','top'],a:'Gerne! 😊 Noch etwas, wobei ich helfen kann?'}
],en:[
  {q:['hello','hi','good morning','good day'],a:'Good morning! 👋 How can I help you today? I can check bookings, verify availability, or remind guests.'},
  {q:['booking','available','availability','free'],a:'The villa is still available next week — July 28 to August 3. Should I create a booking?'},
  {q:['guest','guests','remind','check-in'],a:'You have 2 upcoming check-ins: August 11 (Müller Family) and August 24 (Elena Lombardi). Shall I remind both?'},
  {q:['payment','paid','pending','outstanding'],a:'2 payments are still pending: Elena Lombardi (€520) and Schmidt Group (€798). Should I send a payment reminder?'},
  {q:['revenue','month','income','earnings'],a:'This month: €4,850 revenue from 12 bookings. That\'s up 12% from last month. The entire villa accounts for 58% of revenue.'},
  {q:['report','analysis','analytics'],a:'August forecast: 15 bookings expected, ~€6,000 revenue. Best week: Aug 18-24 with 5 bookings. Shall I generate the monthly report?'},
  {q:['thanks','great','awesome'],a:'You\'re welcome! 😊 Anything else I can help with?'}
]};
function sendAI(){
  const input=document.getElementById('aiInput');const text=input.value.trim();if(!text)return;
  input.value='';demoNotice();
}

/* ════════ UI HELPERS ════════ */
function openModal(id){document.getElementById(id).classList.add('show')}
function closeModal(id){document.getElementById(id).classList.remove('show')}
function toast(msg){const t=document.createElement('div');t.className='toast';t.textContent=msg;document.body.appendChild(t);setTimeout(()=>t.remove(),2800)}
function demoNotice(){toast(curLang==='en'?'Demo only: no action performed.':'Nur Demo: Keine Aktion ausgeführt.')}
function toastClick(el){if(el.dataset.action==='remind')demoNotice()}
function openModalClick(el){const a=el.dataset.action;if(a==='receipt')openModal('receiptModal')}
function toggleSidebar(){const s=document.getElementById('sidebar'),b=document.getElementById('sidebarBackdrop');s.classList.toggle('open');b.classList.toggle('show')}
function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sidebarBackdrop').classList.remove('show')}
function navTo(section){
  document.querySelectorAll('.sidebar-nav a,.bottom-nav a').forEach(a=>a.classList.remove('active'));
  document.querySelectorAll('.sidebar-nav a').forEach(a=>{if(a.textContent.toLowerCase().includes(section))a.classList.add('active')});
  document.querySelectorAll('.bottom-nav a').forEach(a=>{if(a.textContent.toLowerCase().includes(section))a.classList.add('active')});
  closeSidebar();
  if(section==='bookings')toast(t('bookings.title')+' — 5 '+(curLang==='en'?'active':'aktiv'));
  else if(section==='enquiries')toast(t('enquiries.title')+' — 5 '+(curLang==='en'?'total':'insgesamt'));
  else if(section==='payments')toast(t('payments.title'));
  else if(section==='guests')toast('👥 '+(curLang==='en'?'28 guests registered':'28 Gäste registriert'));
  else if(section==='calendar')toast('📅 '+(curLang==='en'?'August 2026':'August 2026'));
}

/* �═══════ I18N INIT �═══════ */
document.addEventListener('DOMContentLoaded',()=>{
  const saved=localStorage.getItem('ve-lang')||'de';setLang(saved);
  document.querySelectorAll('.modal-overlay').forEach(m=>{m.addEventListener('click',function(e){if(e.target===this)this.classList.remove('show')})});
  renderCal();renderEnquiries();renderBookings();renderPayments();
});
</script>
</body>
</html>