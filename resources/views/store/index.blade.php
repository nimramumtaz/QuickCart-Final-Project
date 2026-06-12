<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mega Mall QuickCart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --qc:#6d28d9; --gold:#f59e0b; --ink:#151127; --muted:#6b647e; }
        body { font-family: system-ui, -apple-system, Segoe UI, sans-serif; background:#f7f4ff; color:var(--ink); }
        .ticker { background:var(--ink); color:white; white-space:nowrap; overflow:hidden; font-size:.88rem; }
        .ticker span { display:inline-block; padding:.55rem 2rem; animation:marquee 24s linear infinite; }
        @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
        .navbar { backdrop-filter: blur(18px); background:rgba(255,255,255,.92); }
        .brand { font-weight:900; font-size:1.6rem; color:var(--qc); letter-spacing:-.04em; }
        .hero { min-height:78vh; background:linear-gradient(135deg, rgba(109,40,217,.92), rgba(21,17,39,.92)), url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=1800&q=80') center/cover; color:white; display:flex; align-items:center; }
        .hero h1 { font-size:clamp(2.5rem,6vw,5.4rem); font-weight:900; letter-spacing:-.05em; line-height:.95; }
        .hero .lead { max-width:680px; color:rgba(255,255,255,.78); }
        .soft-card { border:0; border-radius:8px; box-shadow:0 14px 45px rgba(45,27,110,.13); }
        .category-card { height:150px; color:white; border-radius:8px; overflow:hidden; cursor:pointer; position:relative; background-size:cover; background-position:center; }
        .category-card:before { content:""; position:absolute; inset:0; background:linear-gradient(0deg, rgba(0,0,0,.65), rgba(0,0,0,.12)); }
        .category-card > div { position:absolute; left:1rem; right:1rem; bottom:1rem; }
        .product-card img { height:210px; object-fit:cover; }
        .badge-qc { background:#ede9fe; color:var(--qc); }
        .btn-qc { background:var(--qc); color:white; border:0; }
        .btn-qc:hover { background:#4c1d95; color:white; }
        .btn-gold { background:var(--gold); color:#17120a; border:0; }
        .cart-drawer { position:fixed; top:0; right:-430px; width:min(430px,100vw); height:100vh; z-index:1060; background:white; transition:.25s; box-shadow:-18px 0 50px rgba(0,0,0,.22); display:flex; flex-direction:column; }
        .cart-drawer.open { right:0; }
        .ai-box { position:fixed; right:1.2rem; top:6.4rem; z-index:1050; width:min(360px, calc(100vw - 2rem)); }
        .ai-box .card { overflow:hidden; border:1px solid rgba(109,40,217,.14); }
        .ai-box .card-body { padding:1rem; }
        .ai-box #aiAnswer { max-height:120px; overflow:auto; }
        .toast-wrap { position:fixed; right:1rem; top:5rem; z-index:1080; }
        .form-control:focus, .form-select:focus { border-color:var(--qc); box-shadow:0 0 0 .2rem rgba(109,40,217,.15); }
        .section-title { font-weight:900; letter-spacing:-.04em; }
        @media(max-width:991px){
            .ai-box { position:sticky; top:5rem; right:auto; width:auto; margin:1rem; }
        }
    </style>
</head>
<body>
<div class="ticker"><span>Free delivery above Rs.1,500 &nbsp; | &nbsp; Cash on Delivery &nbsp; | &nbsp; AI shopping assistant &nbsp; | &nbsp; 72 products in 16 departments &nbsp; | &nbsp; Same-day delivery in Faisalabad &nbsp; | &nbsp;</span><span>Free delivery above Rs.1,500 &nbsp; | &nbsp; Cash on Delivery &nbsp; | &nbsp; AI shopping assistant &nbsp; | &nbsp; 72 products in 16 departments &nbsp; | &nbsp;</span></div>

<nav class="navbar navbar-expand-lg sticky-top border-bottom">
    <div class="container py-2">
        <a class="navbar-brand brand" href="#">Quick<span class="text-warning">Cart</span></a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <div class="mx-lg-4 my-3 my-lg-0 flex-grow-1">
                <input id="searchInput" class="form-control rounded-pill" placeholder="Search products, brands, categories">
            </div>
            <div class="navbar-nav gap-lg-2 align-items-lg-center">
                <a class="nav-link" href="#shop">Shop</a>
                <a class="nav-link" href="#deals">Deals</a>
                <a class="nav-link" href="#contact">Contact</a>
                <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin</a>
                <button class="btn btn-qc btn-sm" onclick="toggleCart()"><i class="bi bi-bag"></i> Cart <span id="cartCount" class="badge text-bg-warning">0</span></button>
            </div>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge text-bg-light text-dark mb-3">Pakistan's Mega Mall, now with Laravel backend</span>
                <h1>Shop everything you love and need.</h1>
                <p class="lead fs-4 mt-3">Food, fashion, electronics, beauty, sports, books, grocery, pharmacy and more. Real product images, database orders, contact messages, newsletter records, and a Gemini-ready AI assistant.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a class="btn btn-gold btn-lg rounded-pill px-4" href="#shop"><i class="bi bi-bag-heart"></i> Shop Now</a>
                    <a class="btn btn-outline-light btn-lg rounded-pill px-4" href="#ai"><i class="bi bi-stars"></i> Ask AI</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card soft-card text-dark">
                    <div class="card-body p-4">
                        <div class="row text-center g-3">
                            <div class="col-6"><h3 class="fw-bold text-primary">{{ $products->count() }}</h3><small>Products</small></div>
                            <div class="col-6"><h3 class="fw-bold text-primary">{{ $categories->count() }}</h3><small>Categories</small></div>
                            <div class="col-6"><h3 class="fw-bold text-primary">4.9</h3><small>Rating</small></div>
                            <div class="col-6"><h3 class="fw-bold text-primary">COD</h3><small>Payment</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    <section class="container py-5" id="shop">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div>
                <p class="text-primary fw-bold mb-1">All Departments</p>
                <h2 class="section-title display-6 mb-0">Browse Categories</h2>
            </div>
            <select id="sortSelect" class="form-select w-auto">
                <option value="default">Sort: Default</option>
                <option value="low">Price: Low to High</option>
                <option value="high">Price: High to Low</option>
                <option value="rating">Top Rated</option>
            </select>
        </div>
        <div class="row g-3 mb-5">
            <div class="col-6 col-md-3 col-lg-2">
                <div class="category-card" data-cat="all" style="background-image:url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=700&q=80')"><div><b>All</b><br><small>{{ $products->count() }} items</small></div></div>
            </div>
            @foreach($categories as $category)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="category-card" data-cat="{{ $category['id'] }}" style="background-image:url('{{ $category['image'] }}')"><div><b>{{ $category['name'] }}</b><br><small>{{ $category['count'] }} items</small></div></div>
                </div>
            @endforeach
        </div>
        <div class="row g-4" id="productGrid"></div>
    </section>

    <section class="py-5 bg-dark text-white" id="deals">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-warning fw-bold mb-1">Limited Time</p>
                    <h2 class="section-title display-6">Flash Deals</h2>
                </div>
                <div class="fs-5"><i class="bi bi-clock"></i> Ends tonight</div>
            </div>
            <div class="row g-4">
                @foreach($featured as $product)
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 soft-card">
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <span class="badge badge-qc">{{ $product->badge }}</span>
                                <h5 class="mt-2">{{ $product->name }}</h5>
                                <div class="fw-bold text-primary">Rs. {{ number_format($product->price) }}</div>
                                <button class="btn btn-qc btn-sm mt-3" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container py-5" id="contact">
        <div class="row g-4">
            <div class="col-lg-5">
                <p class="text-primary fw-bold mb-1">Support</p>
                <h2 class="section-title display-6">Contact QuickCart</h2>
                <p class="text-secondary">Messages are saved in the Laravel database and an email is attempted through Laravel Mail. With default log mailer, emails appear in <code>storage/logs/laravel.log</code>.</p>
                <div class="list-group soft-card">
                    <div class="list-group-item"><i class="bi bi-geo-alt text-primary"></i> Main Boulevard, Faisalabad</div>
                    <div class="list-group-item"><i class="bi bi-telephone text-primary"></i> 03194854924</div>
                    <div class="list-group-item"><i class="bi bi-envelope text-primary"></i> nimramumtaz29@gmail.com</div>
                </div>
            </div>
            <div class="col-lg-7">
                <form id="contactForm" class="card soft-card p-4">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">First Name</label><input name="first_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Last Name</label><input name="last_name" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Department</label><select name="department" class="form-select"><option>General Inquiry</option><option>Order Support</option><option>Return / Refund</option><option>Become a Seller</option></select></div>
                        <div class="col-12"><label class="form-label">Message</label><textarea name="message" class="form-control" rows="4" required></textarea></div>
                        <div class="col-12"><button class="btn btn-qc w-100">Send Message</button></div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <form id="newsletterForm" class="row g-3 align-items-center">
                <div class="col-lg-6"><h2 class="section-title mb-0">Get 10% off your first order</h2></div>
                <div class="col-lg-4"><input name="email" type="email" class="form-control form-control-lg" placeholder="Email address" required></div>
                <div class="col-lg-2"><button class="btn btn-gold btn-lg w-100">Subscribe</button></div>
            </form>
        </div>
    </section>
</main>

<div class="cart-drawer" id="cartDrawer">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-bold">Shopping Cart</h4>
        <button class="btn btn-light" onclick="toggleCart(false)"><i class="bi bi-x-lg"></i></button>
    </div>
    <div id="cartItems" class="p-4 flex-grow-1 overflow-auto"></div>
    <form id="checkoutForm" class="p-4 border-top">
        <div class="d-flex justify-content-between fw-bold fs-5 mb-3"><span>Total</span><span id="cartTotal">Rs. 0</span></div>
        <div class="row g-2">
            <div class="col-6"><input name="first_name" class="form-control" placeholder="First name" required></div>
            <div class="col-6"><input name="last_name" class="form-control" placeholder="Last name"></div>
            <div class="col-6"><input name="phone" class="form-control" placeholder="Phone" required></div>
            <div class="col-6"><input name="email" type="email" class="form-control" placeholder="Email"></div>
            <div class="col-12"><input name="address" class="form-control" placeholder="Address" required></div>
            <div class="col-6"><input name="city" class="form-control" value="Faisalabad"></div>
            <div class="col-6"><select name="payment_method" class="form-select"><option>Cash on Delivery</option><option>Easypaisa</option><option>JazzCash</option><option>Bank Transfer</option></select></div>
            <div class="col-12"><input name="promo_code" class="form-control" placeholder="Promo code optional"></div>
            <div class="col-12"><textarea name="notes" class="form-control" rows="2" placeholder="Special instructions"></textarea></div>
            <div class="col-12"><button class="btn btn-qc w-100">Place Order</button></div>
        </div>
    </form>
</div>

<div class="ai-box" id="ai">
    <div class="card soft-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <b><i class="bi bi-stars text-primary"></i> QuickCart AI</b>
            <span class="badge badge-qc">Gemini-ready</span>
        </div>
        <div class="card-body">
            <div id="aiAnswer" class="small text-secondary mb-3">Ask for product suggestions, cheap items, best electronics, gifts, or beauty picks.</div>
            <form id="aiForm" class="input-group">
                <input name="message" class="form-control" placeholder="Ask AI assistant..." required>
                <button class="btn btn-qc"><i class="bi bi-send"></i></button>
            </form>
        </div>
    </div>
</div>
<div class="toast-wrap" id="toastWrap"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const products = @json($products);
const money = n => 'Rs. ' + Number(n).toLocaleString();
let activeCat = 'all';
let cart = JSON.parse(localStorage.getItem('quickcart_cart') || '{}');

function saveCart(){ localStorage.setItem('quickcart_cart', JSON.stringify(cart)); renderCart(); }
function toast(msg){ document.getElementById('toastWrap').innerHTML = `<div class="alert alert-dark soft-card">${msg}</div>`; setTimeout(()=>toastWrap.innerHTML='',2600); }
function filteredProducts(){
    const term = searchInput.value.toLowerCase().trim();
    let list = products.filter(p => activeCat === 'all' || p.category === activeCat)
        .filter(p => !term || [p.name,p.description,p.category].join(' ').toLowerCase().includes(term));
    if (sortSelect.value === 'low') list.sort((a,b)=>a.price-b.price);
    if (sortSelect.value === 'high') list.sort((a,b)=>b.price-a.price);
    if (sortSelect.value === 'rating') list.sort((a,b)=>b.rating-a.rating);
    return list;
}
function renderProducts(){
    productGrid.innerHTML = filteredProducts().map(p => `
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card product-card h-100 soft-card">
                <img src="${p.image_url}" class="card-img-top" alt="${p.name}">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <span class="badge badge-qc">${p.badge}</span>
                        <span class="small text-warning"><i class="bi bi-star-fill"></i> ${p.rating}</span>
                    </div>
                    <h5 class="mt-2">${p.name}</h5>
                    <p class="text-secondary small flex-grow-1">${p.description}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div><b class="text-primary">${money(p.price)}</b>${p.old_price ? `<small class="text-decoration-line-through text-secondary ms-1">${money(p.old_price)}</small>` : ''}</div>
                        <button class="btn btn-qc btn-sm" onclick="addToCart(${p.id})"><i class="bi bi-plus-lg"></i></button>
                    </div>
                </div>
            </div>
        </div>`).join('');
}
function addToCart(id){ cart[id] = (cart[id] || 0) + 1; saveCart(); toast('Added to cart'); }
function changeQty(id, delta){ cart[id] += delta; if(cart[id] <= 0) delete cart[id]; saveCart(); }
function renderCart(){
    const lines = Object.entries(cart).map(([id, qty]) => ({...products.find(p => p.id == id), quantity:qty}));
    const subtotal = lines.reduce((s,i)=>s+i.price*i.quantity,0);
    const delivery = subtotal > 0 && subtotal < 1500 ? 150 : 0;
    cartCount.textContent = lines.reduce((s,i)=>s+i.quantity,0);
    cartTotal.textContent = money(subtotal + delivery);
    cartItems.innerHTML = lines.length ? lines.map(i => `
        <div class="d-flex gap-3 border-bottom py-3">
            <img src="${i.image_url}" width="72" height="72" class="rounded object-fit-cover" alt="${i.name}">
            <div class="flex-grow-1">
                <b>${i.name}</b><br><small class="text-secondary">${money(i.price)} x ${i.quantity}</small>
                <div class="mt-2">
                    <button class="btn btn-sm btn-light" onclick="changeQty(${i.id},-1)">-</button>
                    <span class="px-2">${i.quantity}</span>
                    <button class="btn btn-sm btn-light" onclick="changeQty(${i.id},1)">+</button>
                </div>
            </div>
            <b>${money(i.price*i.quantity)}</b>
        </div>`).join('') + `<div class="d-flex justify-content-between py-3"><span>Delivery</span><b>${delivery ? money(delivery) : 'Free'}</b></div>` : '<p class="text-secondary">Your cart is empty.</p>';
}
function toggleCart(force){ cartDrawer.classList.toggle('open', force ?? !cartDrawer.classList.contains('open')); }
async function postForm(url, payload){
    const res = await fetch(url, {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,'Accept':'application/json'}, body:JSON.stringify(payload)});
    if(!res.ok) throw await res.json();
    return res.json();
}
document.querySelectorAll('.category-card').forEach(card => card.onclick = () => { activeCat = card.dataset.cat; renderProducts(); document.getElementById('shop').scrollIntoView(); });
searchInput.oninput = renderProducts;
sortSelect.onchange = renderProducts;
checkoutForm.onsubmit = async e => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(checkoutForm).entries());
    data.cart = Object.entries(cart).map(([id, quantity]) => ({id:Number(id), quantity:Number(quantity)}));
    try { const json = await postForm('{{ route('checkout.store') }}', data); cart = {}; saveCart(); toggleCart(false); toast('Order confirmed: ' + json.order_number); checkoutForm.reset(); }
    catch { toast('Please check checkout fields.'); }
};
contactForm.onsubmit = async e => {
    e.preventDefault();
    try { await postForm('{{ route('contact.message') }}', Object.fromEntries(new FormData(contactForm).entries())); toast('Message saved in backend'); contactForm.reset(); }
    catch { toast('Please check contact form.'); }
};
newsletterForm.onsubmit = async e => {
    e.preventDefault();
    const json = await postForm('{{ route('newsletter.store') }}', Object.fromEntries(new FormData(newsletterForm).entries()));
    toast('Subscribed. Coupon: ' + json.coupon_code);
    newsletterForm.reset();
};
aiForm.onsubmit = async e => {
    e.preventDefault();
    aiAnswer.textContent = 'Thinking...';
    const json = await postForm('{{ route('ai.ask') }}', Object.fromEntries(new FormData(aiForm).entries()));
    aiAnswer.innerHTML = `<b>${json.source}:</b> ${json.answer}`;
};
renderProducts(); renderCart();
</script>
</body>
</html>
