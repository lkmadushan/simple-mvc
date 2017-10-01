<?php require('partials/head.php'); ?>

<?php require('partials/form.php'); ?>

<?php if (isset($bill)): ?>
<section style="margin-bottom: 50px" class="section is-paddingless">
    <div class="container">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Your billing information</p>
            </header>
            <div class="card-content">
                <div class="content">
                    <span class="icon is-small">
                        <i class="fa fa-calendar"></i>
                    </span>
                    Total number of days: <?php echo $bill->days() ?>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-money"></i>
                    </span>
                    Total amount of the bill: <?php echo $bill->total() ?>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    Total expense amount by each friend:
                    <ul>
                        <?php foreach ($bill->expenseByUsers() as $user => $value): ?>
                            <li><?php echo $user ?> : <?php echo $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    Due amount by each friend:
                    <ul>
                        <?php foreach ($bill->dueByUsers() as $user => $value): ?>
                            <li><?php echo $user ?> : <?php echo $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    Settlement combination:
                    <ul>
                        <?php foreach ($bill->settlement() as $user => $settlements): ?>
                            <li>
                                <dl><?php echo $user ?> :</dl>
                                <?php foreach ($settlements as $settlement): ?>
                                    <dt>from - <?php echo $settlement['from'] ?></dt>
                                    <dt>amount <?php echo $settlement['amount'] ?></dt>
                                    <br>
                                <?php endforeach; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require('partials/footer.php'); ?>
