<?php require('partials/head.php'); ?>

<?php require('partials/form.php'); ?>

<?php if (isset($bill)): ?>
<section class="section is-paddingless">
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
                    Total amount spent by all friend: <?php echo $bill->total() ?>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    How much each friend has spent:
                    <ul>
                        <?php foreach ($bill->spentByUsers() as $user => $value): ?>
                            <li><?php echo $user ?> : <?php echo $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    How much each friend should share:
                    <ul>
                        <?php foreach ($bill->shareByUsers() as $user => $value): ?>
                            <li><?php echo $user ?> : <?php echo $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    How much each friend owes:
                    <ul>
                        <?php foreach ($bill->oweByUsers() as $user => $value): ?>
                            <li><?php echo $user ?> : <?php echo $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                    <span class="icon is-small">
                        <i class="fa fa-users"></i>
                    </span>
                    Settlement combination:
                    <ul>
                        <?php foreach ($bill->settlement() as $user => $value): ?>
                            <li><?php echo $user ?> : <?php echo $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require('partials/footer.php'); ?>
