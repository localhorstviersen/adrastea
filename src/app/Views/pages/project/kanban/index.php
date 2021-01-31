<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div id="kanbanBoard"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
<link rel="stylesheet" href="/assets/css/jkanban.min.css">
<script src="/assets/js/jkanban.min.js"></script>

<script type="application/javascript">
    var KanbanBoard = new jKanban({
        element: "#kanbanBoard",
        gutter: "10px",
        widthBoard: "450px",
        dragBoards: false,
        dropEl: function (el, target, source, sibling) {
            console.log(target.parentElement.getAttribute('data-id'));
        },
        itemAddOptions: {
            enabled: false
        },
        boards: [
            <?php foreach ($this->data['status'] as $status): ?>
            {
                id: "board-<?= $status->id ?>",
                title: "<?= $status->name ?>",
                item: [
                    <?php foreach ($status->getTickets() as $ticket): ?>
                    {
                        id: "item-<?= $ticket->id ?>",
                        title: "<?= $ticket->getFieldValue('title') ?>"
                    },
                    <?php endforeach; ?>
                ]
            },
            <?php endforeach; ?>
        ]
    });

    KanbanBoard.add
</script>
<?= $this->endSection() ?>
