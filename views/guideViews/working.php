<?php
date_default_timezone_set('Asia/Bangkok');

// day đang xem
$dayViewing = isset($_GET['day']) ? (int) $_GET['day'] : 1;
if (!isset($itinerariesByDay[$dayViewing])) {
    $dayViewing = array_key_first($itinerariesByDay);
}
$itemsToday = $itinerariesByDay[$dayViewing] ?? [];

// day hiện tại của tour (tính theo ngày khởi hành)
$startDateStr = !empty($currentTour['assignment_started_at'])
    ? substr($currentTour['assignment_started_at'], 0, 10) // YYYY-mm-dd
    : date('Y-m-d');

$start = new DateTime($startDateStr);
$today = new DateTime('today');

$dayCurrent = (int) $start->diff($today)->format('%a') + 1;

// clamp vào [1..maxDay]
$maxDay = !empty($itinerariesByDay) ? max(array_keys($itinerariesByDay)) : 1;
$dayCurrent = max(1, min($dayCurrent, $maxDay));

function statusByDayAndTime(int $dayViewing, int $dayCurrent, ?string $start, ?string $end): array
{
    if ($dayViewing < $dayCurrent)
        return ['timeline-done', 'Hoàn thành', '✓ '];
    if ($dayViewing > $dayCurrent)
        return ['timeline-upcoming', 'Sắp tới', ''];
    if (empty($start) || empty($end))
        return ['timeline-upcoming', 'Sắp tới', ''];

    $today = date('Y-m-d');
    $now = time();
    $s = strtotime("$today $start");
    $e = strtotime("$today $end");

    // qua nửa đêm
    if ($e < $s)
        $e += 86400;

    if ($now < $s)
        return ['timeline-upcoming', 'Sắp tới', ''];
    if ($now <= $e)
        return [
            'timeline-running',
            'Đang diễn ra',
            '<i class="fa-solid fa-circle-play text-primary me-1"></i>'
        ];

    return ['timeline-done', 'Hoàn thành', '✓ '];
}

function h($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}
function fmtTime($t)
{
    return $t ? date('H:i', strtotime($t)) : '';
}
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Lịch Làm Việc - HDV</h1>

    </div>
    <div class="status-card d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="status-icon-circle">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div>
                <div class="status-subtitle">Trạng thái hiện tại</div>
                <div class="status-title">Đang dẫn tour</div>
            </div>
        </div>
        <div class="text-md-end">
            <div class="status-right-label">Số khách</div>
            <div class="status-right-value"><?= count($customers) . '/' . count($customers) ?></div>
        </div>
    </div>

    <!-- Tour card -->
    <div class="card tour-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="tour-title"><?= $currentTour['tour_name'] ?? "" ?></div>
                    <div class="tour-sub">
                        <?= $currentTour['assignment_started_at'] ?> - <?= $currentTour['assignment_ended_at'] ?>
                        (<?= $currentTour['tour_duration_day'] ?> ngày <?= $currentTour['tour_duration_night'] ?> đêm)
                    </div>
                </div>
                <div class="ms-3">
                    <span class="pill-day">
                        Ngày <?= (int) $dayCurrent ?>/<?= (int) ($currentTour['tour_duration_day'] ?? 0) ?>
                    </span>
                </div>
            </div>

            <!-- Summary -->
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="summary-box blue">
                        <div class="summary-label">Số khách</div>
                        <div class="summary-value-main"><?= count($customers) ?></div>
                    </div>
                </div>

                <?php
                $totalDays = (int) ($currentTour['tour_duration_day'] ?? 0);
                $remainingDays = max(0, $totalDays - (int) $dayCurrent);
                ?>

                <div class="col-md-6">
                    <div class="summary-box purple">
                        <div class="summary-label">Còn lại</div>
                        <div class="summary-value-main"><?= $remainingDays ?> ngày</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="row g-3 action-row">
                <div class="col-md-12">
                    <a style="text-decoration: none" href="/guide/current-tour/customers"
                        class="w-100 action-btn action-blue">
                        <i class="fa-solid fa-users"></i>
                        Xem danh sách khách (<?= count($customers) ?>) và & điểm danh
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Timeline today -->
    <div class="card timeline-card">
        <div class="card-body p-4">

            <!-- Title -->
            <div class="timeline-title mb-3">
                Lịch Trình - Ngày <?= (int) $dayViewing ?>
            </div>

            <!-- Tabs chọn ngày -->
            <div class="d-flex gap-2 mb-4 flex-wrap">
                <?php foreach ($itinerariesByDay as $d => $items): ?>
                    <a href="/guide/current-tour?day=<?= (int) $d ?>"
                        class="btn <?= ($d == $dayViewing) ? 'btn-primary' : 'btn-outline-primary' ?>">
                        Ngày <?= (int) $d ?>
                    </a>
                <?php endforeach; ?>
                <form method="post" class="ms-auto">
                    <button onclick="return confirm('Bạn có chắc muốn hoàn thành tour không, hành động này không thể hoàn tác ?')" type="submit" class="btn btn-success btn-finish-tour">
                        <i class="fa-solid fa-circle-check me-2"></i>Hoàn thành tour
                    </button>
                </form>
            </div>

            <?php if (empty($itemsToday)): ?>
                <div class="text-muted">Chưa có lịch trình cho ngày này.</div>
            <?php else: ?>
                <?php foreach ($itemsToday as $it): ?>
                    <?php
                    [$cls, $label, $prefix] = statusByDayAndTime(
                        (int) $dayViewing,
                        (int) $dayCurrent,
                        $it['start_time'] ?? null,
                        $it['end_time'] ?? null
                    );
                    ?>
                    <div class="timeline-item <?= h($cls) ?>">
                        <div class="timeline-time text-center">
                            <div class="mb-1"><i class="fa-regular fa-clock"></i></div>
                            <?= h(fmtTime($it['start_time'] ?? '')) ?>
                        </div>

                        <div class="flex-grow-1">
                            <div class="timeline-main-title">
                                <?= $prefix ?>         <?= h($it['title'] ?? '') ?>
                            </div>
                            <div class="timeline-desc">
                                <?= nl2br(h($it['description'] ?? '')) ?>
                            </div>
                        </div>

                        <div>
                            <span class="timeline-badge"><?= h($label) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>


    <!-- Important notes -->
    <?php if ($currentTour['booking_notes']): ?>
        <div class="card note-card">
            <div class="card-body p-4">
                <div class="section-heading">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Ghi chú của đoàn</span>
                </div>
                <div class="note-item note-veg">
                    <div class="note-desc"><?= $currentTour['booking_notes'] ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<style>
    .guide-schedule-page {
        padding-top: 24px;
        padding-bottom: 40px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .btn-toggle-status {
        border-radius: 999px;
        padding: 8px 18px;
        font-size: 14px;
        font-weight: 600;
        background: #4b5563;
        color: #fff;
        border: none;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.25);
    }

    .btn-toggle-status:hover {
        background: #374151;
        color: #fff;
    }

    .status-card {
        background: linear-gradient(90deg, #ff8c00, #ff6b00);
        color: #ffffff;
        border-radius: 20px;
        padding: 22px 28px;
        box-shadow: 0 12px 32px rgba(148, 64, 0, 0.3);
        margin-bottom: 28px;
    }

    .status-icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-right: 16px;
    }

    .status-subtitle {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.95;
    }

    .status-title {
        font-size: 22px;
        font-weight: 800;
    }

    .status-right-label {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 2px;
    }

    .status-right-value {
        font-size: 24px;
        font-weight: 800;
    }

    .tour-card {
        border-radius: 22px;
        border: none;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.10);
        margin-bottom: 28px;
    }

    .tour-title {
        font-size: 22px;
        font-weight: 800;
        color: #111827;
    }

    .tour-sub {
        color: #6b7280;
        font-size: 14px;
    }

    .pill-day {
        background: #d1fae5;
        color: #047857;
        border-radius: 999px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .summary-box {
        border-radius: 18px;
        padding: 14px 18px;
        margin-top: 18px;
        height: 100%;
    }

    .summary-label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .summary-value-main {
        font-size: 22px;
        font-weight: 800;
    }

    .summary-box.blue {
        background: #e5f0ff;
        color: #1d4ed8;
    }

    .summary-box.green {
        background: #ecfdf3;
        color: #15803d;
    }

    .summary-box.purple {
        background: #f5ebff;
        color: #7c3aed;
    }

    .action-row {
        margin-top: 22px;
    }

    .action-btn {
        border-radius: 12px;
        padding: 12px 18px;
        font-weight: 600;
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 14px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.18);
    }

    .action-btn i {
        font-size: 16px;
    }

    .action-blue {
        background: #2563eb;
    }

    .action-green {
        background: #16a34a;
    }

    .action-purple {
        background: #8b5cf6;
    }

    .action-orange {
        background: #f97316;
    }

    .action-btn:hover {
        opacity: 0.93;
        color: #fff;
    }

    /* Timeline card */
    .timeline-card {
        border-radius: 22px;
        border: none;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.12);
        margin-bottom: 28px;
    }

    .timeline-title {
        font-size: 20px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 18px;
    }

    .timeline-item {
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        background: #f9fafb;
        border-left: 5px solid #e5e7eb;
    }

    .timeline-time {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        min-width: 48px;
    }

    .timeline-main-title {
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
        font-size: 15px;
    }

    .timeline-desc {
        font-size: 13px;
        color: #6b7280;
    }

    .timeline-badge {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* trạng thái item */
    .timeline-done {
        background: #ecfdf3;
        border-left-color: #22c55e;
    }

    .timeline-done .timeline-badge {
        background: #bbf7d0;
        color: #166534;
    }

    .timeline-running {
        background: #e5f0ff;
        border-left-color: #2563eb;
    }

    .timeline-running .timeline-badge {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .timeline-upcoming {
        background: #f9fafb;
        border-left-color: #e5e7eb;
    }

    .timeline-upcoming .timeline-badge {
        background: #e5e7eb;
        color: #4b5563;
    }

    /* Notes & emergency cards */
    .note-card,
    .emergency-card {
        border-radius: 22px;
        border: none;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.10);
        margin-bottom: 24px;
    }

    .section-heading {
        font-size: 20px;
        font-weight: 800;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .section-heading i {
        color: #ff8c00;
    }

    .note-item {
        border-radius: 14px;
        padding: 12px 16px;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .note-title {
        font-weight: 700;
        margin-bottom: 3px;
    }

    .note-desc {
        font-size: 13px;
        color: #6b7280;
    }

    .note-veg {
        background: #fffbeb;
        border-left: 4px solid #facc15;
    }

    .note-diabetes {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
    }

    .note-room {
        background: #eff6ff;
        border-left: 4px solid #2563eb;
    }

    .note-kid {
        background: #f5f3ff;
        border-left: 4px solid #8b5cf6;
    }

    .emergency-item {
        border-radius: 14px;
        background: #f9fafb;
        padding: 12px 16px;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .emergency-label {
        color: #6b7280;
        margin-bottom: 4px;
    }

    .emergency-value {
        font-weight: 700;
        font-size: 15px;
        color: #111827;
    }
</style>