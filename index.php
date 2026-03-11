<!DOCTYPE html>
<html>
    <?php
    $host='localhost';
    $db = 'webshop';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn ="mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXEPTION,
        PDO::ATTR_DEFAULT_FETCHE_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try
    {
        $connect =new PDO($dsn, $user, $pass, $opt);
        echo "Verbinding is gemaakt";
    }
    catch(PDOexeption $e)
    {
        echo $e->getMessage();
        die("Sorry, Database probleem")
    }
    
    $sql ="SELECT* FROM studenten";
    $statement = $pdo->prepare($sql);
    $statement = execute();
    $student= $statement->fetchAll();
    ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>La Pietra — Artisanale Pizza</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
</head>

<body>

    <!-- ══ HEADER ══════════════════════════════════════════════════ -->
    <header>
        <div class="logo">
            La Pietra
            <span>Artisanale Pizza · Amsterdam</span>
        </div>
        <nav>
            <a href="#">Menu</a>
            <a href="#">Ons Verhaal</a>
            <a href="#">Reserveren</a>
            <a href="#">Contact</a>
            <button class="btn-login" onclick="openLogin()">Inloggen</button>
        </nav>
    </header>

    <!-- ══ TABBAR ══════════════════════════════════════════════════ -->
    <div class="tab-bar">
        <button class="active">Alle pizza's</button>
        <button>Klassiek</button>
        <button>Signature</button>
        <button>Vegetarisch</button>
        <button>Seizoen</button>
        <div class="tab-bar-spacer"></div>
        <div class="search-wrap">
            <input type="text" placeholder="Zoek een pizza..." />
            <button aria-label="Zoeken">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </button>
        </div>
    </div>

    <!-- ══ BODY LAYOUT ═════════════════════════════════════════════ -->
    <div class="layout">

        <!-- ── MENU ───────────────────────────────────────────────── -->
        <main>

            <article class="pizza-card">
                <div class="pizza-image">
                    <img src="https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=400&q=80" alt="Margherita"
                        loading="lazy" />
                </div>
                <div class="pizza-info">
                    <h2>Margherita</h2>
                    <p class="desc">De moeder aller pizza's. Eenvoudig, eerlijk en onvergetelijk.</p>
                    <p class="ingredients">San Marzano tomaat · Fior di latte · Basilicum · Extra vergine olijfolie</p>
                </div>
                <div class="pizza-actions">
                    <span class="price">€ 14,50</span>
                    <button class="btn-add" onclick="addToCart('Margherita', 14.50)">Toevoegen</button>
                </div>
            </article>

            <article class="pizza-card">
                <div class="pizza-image">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&q=80"
                        alt="Tartufo Nero" loading="lazy" />
                </div>
                <div class="pizza-info">
                    <h2>Tartufo Nero</h2>
                    <p class="desc">Zwarte truffel ontmoet zachte stracciatella op een krokante bodem.</p>
                    <p class="ingredients">Truffelroom · Stracciatella · Zwarte truffel · Rucola · Parmigiano</p>
                </div>
                <div class="pizza-actions">
                    <span class="price">€ 22,00</span>
                    <button class="btn-add" onclick="addToCart('Tartufo Nero', 22.00)">Toevoegen</button>
                </div>
            </article>

            <article class="pizza-card">
                <div class="pizza-image">
                    <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400&q=80" alt="Diavola"
                        loading="lazy" />
                </div>
                <div class="pizza-info">
                    <h2>Diavola</h2>
                    <p class="desc">Voor wie houdt van pit. Soppressata piccante met een vleugje honing.</p>
                    <p class="ingredients">Tomaat · Fior di latte · Soppressata piccante · Calabrese chili · Honing</p>
                </div>
                <div class="pizza-actions">
                    <span class="price">€ 17,00</span>
                    <button class="btn-add" onclick="addToCart('Diavola', 17.00)">Toevoegen</button>
                </div>
            </article>

        </main>

        <!-- ── CART SIDEBAR ────────────────────────────────────────── -->
        <aside>
            <div class="cart-heading">Uw Bestelling</div>

            <div id="cart-items">
                <p class="cart-empty">Nog niets toegevoegd.</p>
            </div>

            <div class="cart-footer">
                <div class="cart-total">
                    <span class="label">Totaal</span>
                    <span class="amount" id="cart-total">€ 0,00</span>
                </div>
                <button class="btn-order" onclick="placeOrder()">Bestelling Plaatsen</button>
            </div>
        </aside>

    </div>
    <!-- ══ LOGIN MODAL ══════════════════════════════════════════════ -->
    <div id="login-modal"
        style="display:none; position:fixed; inset:0; background:rgba(0,52,89,0.35); z-index:999; align-items:center; justify-content:center; backdrop-filter:blur(4px);"
        onclick="if(event.target===this)closeLogin()">
        <div
            style="background:var(--white); padding:3rem; width:100%; max-width:400px; border:1px solid var(--lavender); position:relative;">
            <button onclick="closeLogin()"
                style="position:absolute;top:1.2rem;right:1.5rem;background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--mocha);">×</button>
            <div
                style="font-size:0.65rem;letter-spacing:0.3em;text-transform:uppercase;color:var(--mocha);margin-bottom:2rem;">
                Inloggen</div>
            <div style="margin-bottom:1.2rem;">
                <label
                    style="font-size:0.55rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--navy);opacity:0.6;display:block;margin-bottom:0.4rem;">E-mailadres</label>
                <input type="email" placeholder="uw@email.nl"
                    style="width:100%;padding:0.7rem 0.9rem;border:1px solid var(--lavender);background:var(--blush);font-size:0.95rem;color:var(--navy);outline:none;" />
            </div>
            <div style="margin-bottom:2rem;">
                <label
                    style="font-size:0.55rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--navy);opacity:0.6;display:block;margin-bottom:0.4rem;">Wachtwoord</label>
                <input type="password" placeholder="••••••••"
                    style="width:100%;padding:0.7rem 0.9rem;border:1px solid var(--lavender);background:var(--blush);font-size:0.95rem;color:var(--navy);outline:none;" />
            </div>
            <button onclick="closeLogin()"
                style="width:100%;font-size:0.6rem;letter-spacing:0.3em;text-transform:uppercase;padding:1rem;background:var(--navy);color:var(--white);border:none;cursor:pointer;transition:background 0.25s;"
                onmouseover="this.style.background='var(--teal)'"
                onmouseout="this.style.background='var(--navy)'">Inloggen</button>
            <p style="text-align:center;margin-top:1.2rem;font-style:italic;font-size:0.85rem;color:var(--mocha);">Nog
                geen account? <a href="#" style="color:var(--teal);text-decoration:none;">Registreer hier</a></p>
        </div>
    </div>
    
<script src="script/script.js"></script>
</body>

</html>