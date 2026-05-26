<?php

$reference = isset($_POST['reference']) ? trim($_POST['reference']) : '';
$alerts = [];
$errorMessage = '';

if ($reference !== '') {
    $url = 'http://localhost:8080/Fourage/api/listAlerts?reference=' . urlencode($reference);

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 8
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        $errorMessage = 'Impossible de joindre l API listAlerts. Verifiez le serveur Java et l URL.';
    } else {
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errorMessage = 'La reponse de l API est invalide.';
        } elseif (!is_array($decoded)) {
            $errorMessage = 'Format de reponse inattendu.';
        } else {
            $alerts = $decoded;
        }
    }
} else {
    $errorMessage = 'La reference est obligatoire.';
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat alertes</title>
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
            max-width: 980px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .result-card {
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 18px 45px rgba(30, 64, 175, 0.12);
            overflow: hidden;
            background: #ffffff;
        }

        .result-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(120deg, #eff6ff 0%, #f8fbff 100%);
            border-bottom: 1px solid var(--card-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .result-header h1 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
        }

        .ref-badge {
            background: var(--brand-soft);
            color: #1e3a8a;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            padding: 0.35rem 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .result-body {
            padding: 1.5rem;
        }

        .table thead th {
            background: #f8fbff;
            color: #334155;
            border-bottom: 1px solid #dbe3f1;
            white-space: nowrap;
        }

        .empty-state {
            border: 1px dashed #bfdbfe;
            background: #f8fbff;
            border-radius: 0.9rem;
            padding: 1.1rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <main class="page-shell">
        <section class="result-card">
            <div class="result-header">
                <h1><i class="bi bi-clipboard-data me-2"></i>Resultat des alertes</h1>
                <span class="ref-badge">Reference: <?= htmlspecialchars($reference, ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <div class="result-body">
                <?php if ($errorMessage !== ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php elseif (count($alerts) === 0): ?>
                    <div class="empty-state">
                        <i class="bi bi-info-circle me-2"></i>Aucune alerte trouvee pour cette reference.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Statut 1</th>
                                    <th scope="col">Statut 2</th>
                                    <th scope="col">Alerte</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alerts as $index => $item): ?>
                                    <tr>
                                        <th scope="row"><?= $index + 1 ?></th>
                                        <td><?= htmlspecialchars($item['statut1'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($item['statut2'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <?php
                                            $alertVal = $item['alert'] ?? '-';
                                            $badgeClass = 'badge bg-secondary';
                                            if ($alertVal === 'J') {
                                                $badgeClass = 'badge bg-warning text-dark';
                                            } elseif ($alertVal === 'R') {
                                                $badgeClass = 'badge bg-danger';
                                            }
                                        ?>
                                        <td><span class="<?= $badgeClass ?>"><?= htmlspecialchars($alertVal, ENT_QUOTES, 'UTF-8') ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mt-4 gap-2 flex-wrap">
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Nouvelle recherche
                    </a>
                    <a href="http://localhost:8080/Fourage/demande/formulaire" class="btn btn-primary">
                        <i class="bi bi-house-door me-1"></i>Retour Forage
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>