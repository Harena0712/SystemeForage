<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche alertes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --brand: #2563eb;
            --brand-soft: #dbeafe;
            --bg: #f6f8fc;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --card-border: #dbe3f1;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--text-main);
            background:
                radial-gradient(circle at 0% 0%, #eef4ff 0%, transparent 40%),
                radial-gradient(circle at 100% 100%, #ecfeff 0%, transparent 35%),
                var(--bg);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .search-card {
            width: 100%;
            max-width: 700px;
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 18px 45px rgba(30, 64, 175, 0.12);
            overflow: hidden;
            background: #ffffff;
        }

        .search-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(120deg, #eff6ff 0%, #f8fbff 100%);
            border-bottom: 1px solid var(--card-border);
        }

        .search-header h1 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
        }

        .search-header p {
            margin: 0.35rem 0 0;
            color: var(--text-muted);
        }

        .search-body {
            padding: 1.5rem;
        }

        .btn-brand {
            background-color: var(--brand);
            border-color: var(--brand);
        }

        .btn-brand:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        .form-text {
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <main class="page-shell">
        <section class="search-card">
            <div class="search-header">
                <h1><i class="bi bi-bell me-2"></i>Recherche des alertes de statut</h1>
                <p>Saisissez la reference d'une demande pour consulter les alertes generees.</p>
            </div>

            <div class="search-body">
                <form action="resultat.php" method="POST" class="row g-3">
                    <div class="col-12">
                        <label for="reference" class="form-label fw-semibold">Reference de demande</label>
                        <input
                            id="reference"
                            type="text"
                            name="reference"
                            class="form-control form-control-lg"
                            placeholder="Ex: REF-0001"
                            required
                        >
                        <div class="form-text">Cette valeur sera envoyee a l'API Java: /api/listAlerts</div>
                    </div>

                    <div class="col-12 d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <a href="http://localhost:8080/Fourage/demande/formulaire" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Retour Forage
                        </a>
                        <button type="submit" class="btn btn-brand text-white px-4">
                            <i class="bi bi-send me-1"></i>Voir les resultats
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>