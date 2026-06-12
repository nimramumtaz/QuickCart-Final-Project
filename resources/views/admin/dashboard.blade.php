<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuickCart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --qc:#6d28d9; --gold:#f59e0b; --ink:#141022; --soft:#f6f3ff; }
        body { background:linear-gradient(180deg,#f7f3ff 0,#f8fafc 42%); color:var(--ink); font-family:system-ui,-apple-system,Segoe UI,sans-serif; }
        .admin-shell { max-width:1180px; margin:auto; }
        .topbar { background:rgba(255,255,255,.86); backdrop-filter:blur(18px); border-bottom:1px solid rgba(109,40,217,.12); }
        .brand { font-weight:900; color:var(--qc); letter-spacing:-.04em; }
        .hero-card { background:linear-gradient(135deg,#6d28d9,#25124d 70%); color:white; border:0; border-radius:8px; overflow:hidden; position:relative; }
        .hero-card:after { content:""; position:absolute; width:260px; height:260px; right:-80px; top:-90px; border-radius:50%; background:rgba(245,158,11,.28); }
        .avatar { width:74px; height:74px; border-radius:50%; display:grid; place-items:center; background:white; color:var(--qc); font-size:2rem; font-weight:900; }
        .soft-card { border:0; border-radius:8px; box-shadow:0 14px 45px rgba(45,27,110,.10); }
        .stat-card { border:0; border-radius:8px; color:white; min-height:128px; overflow:hidden; position:relative; }
        .stat-card i { position:absolute; right:18px; bottom:8px; font-size:4rem; opacity:.18; }
        .stat-products { background:linear-gradient(135deg,#2563eb,#7c3aed); }
        .stat-orders { background:linear-gradient(135deg,#059669,#10b981); }
        .stat-messages { background:linear-gradient(135deg,#f97316,#f59e0b); }
        .stat-revenue { background:linear-gradient(135deg,#be123c,#ec4899); }
        .pill { border-radius:999px; padding:.35rem .7rem; background:#ede9fe; color:var(--qc); font-weight:700; font-size:.78rem; }
        .table thead th { color:#6b647e; font-size:.78rem; text-transform:uppercase; letter-spacing:.04em; }
        .message-card { border-left:4px solid var(--qc); }
        .page-title { font-weight:900; letter-spacing:-.04em; }
    </style>
</head>
<body>
<nav class="navbar topbar sticky-top">
    <div class="container admin-shell py-2">
        <a class="navbar-brand brand fs-3" href="{{ route('store.index') }}">Quick<span class="text-warning">Cart</span> Admin</a>
        <div class="d-flex align-items-center gap-2">
            <span class="pill"><i class="bi bi-person-badge"></i> ID: QC-ADMIN-2026</span>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('store.index') }}"><i class="bi bi-shop"></i> Store</a>
        </div>
    </div>
</nav>

<main class="admin-shell px-3 py-4">
    <section class="card hero-card soft-card mb-4">
        <div class="card-body p-4 p-lg-5 position-relative" style="z-index:1">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8 d-flex gap-3 align-items-center">
                    <div class="avatar">NM</div>
                    <div>
                        <p class="text-warning fw-bold mb-1">Mega Mall QuickCart Control Room</p>
                        <h1 class="page-title mb-1">Welcome, Nimra Mumtaz</h1>
                        <p class="mb-0 text-white-50">Admin profile, live orders, support messages, newsletter subscribers, and revenue summary.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white bg-opacity-10 rounded-2 p-3">
                        <div class="d-flex justify-content-between"><span>Email</span><b>nimramumtaz29@gmail.com</b></div>
                        <div class="d-flex justify-content-between mt-2"><span>Role</span><b>Store Manager</b></div>
                        <div class="d-flex justify-content-between mt-2"><span>Status</span><b class="text-warning">Online</b></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3"><div class="card stat-card stat-products"><div class="card-body"><small>Products</small><h2 class="display-5 fw-bold">{{ $stats['products'] }}</h2><span>Active catalog items</span><i class="bi bi-box-seam"></i></div></div></div>
        <div class="col-md-6 col-xl-3"><div class="card stat-card stat-orders"><div class="card-body"><small>Orders</small><h2 class="display-5 fw-bold">{{ $stats['orders'] }}</h2><span>Customer checkouts</span><i class="bi bi-bag-check"></i></div></div></div>
        <div class="col-md-6 col-xl-3"><div class="card stat-card stat-messages"><div class="card-body"><small>Messages</small><h2 class="display-5 fw-bold">{{ $stats['messages'] }}</h2><span>Support inbox</span><i class="bi bi-chat-dots"></i></div></div></div>
        <div class="col-md-6 col-xl-3"><div class="card stat-card stat-revenue"><div class="card-body"><small>Revenue</small><h2 class="display-6 fw-bold">Rs. {{ number_format($stats['revenue']) }}</h2><span>Total sales value</span><i class="bi bi-cash-stack"></i></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card soft-card">
                <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                    <div><h4 class="mb-0 fw-bold">Recent Orders</h4><small class="text-secondary">Latest customer orders saved in database</small></div>
                    <span class="pill">{{ $orders->count() }} shown</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th></tr></thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="fw-bold text-primary">{{ $order->order_number }}</td>
                                <td>{{ $order->first_name }} {{ $order->last_name }}<br><small class="text-secondary">{{ $order->phone }} @if($order->email) - {{ $order->email }} @endif</small></td>
                                <td><span class="badge text-bg-light">{{ $order->items->count() }} items</span></td>
                                <td class="fw-bold">Rs. {{ number_format($order->total) }}</td>
                                <td><span class="badge rounded-pill text-bg-success px-3 py-2">{{ $order->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-secondary p-4">No orders yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card soft-card mb-4">
                <div class="card-header bg-white border-0 p-4"><h4 class="mb-0 fw-bold">Contact Messages</h4><small class="text-secondary">Support requests from visitors</small></div>
                <div class="card-body pt-0">
                    @forelse($messages as $message)
                        <div class="message-card bg-light rounded-2 p-3 mb-3">
                            <div class="d-flex justify-content-between gap-2">
                                <b>{{ $message->first_name }} {{ $message->last_name }}</b>
                                <span class="badge text-bg-warning">{{ $message->department }}</span>
                            </div>
                            <small class="text-secondary">{{ $message->email }}</small>
                            <p class="mb-0 mt-2">{{ $message->message }}</p>
                        </div>
                    @empty
                        <p class="text-secondary mb-0">No messages yet.</p>
                    @endforelse
                </div>
            </div>
            <div class="card soft-card">
                <div class="card-header bg-white border-0 p-4"><h4 class="mb-0 fw-bold">Newsletter Subscribers</h4><small class="text-secondary">Coupon signups</small></div>
                <div class="list-group list-group-flush">
                    @forelse($subscribers as $subscriber)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3"><span>{{ $subscriber->email }}</span><span class="badge rounded-pill text-bg-primary">{{ $subscriber->coupon_code }}</span></div>
                    @empty
                        <div class="list-group-item text-secondary px-4 py-3">No subscribers yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
