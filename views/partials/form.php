<section class="section">
    <div class="container">
        <h1 class="title">Billing App</h1>
        <h2 class="subtitle">
            A simple application to split the bill payments among a group of friends.
        </h2>

        <form action="" method="POST" name="json" onsubmit="return isValidJson()">
            <div class="field">
                <label class="label">JSON Data</label>
                <div class="control">
                    <textarea name="bill"
                              class="textarea <?php echo isset($errors) ? 'is-danger' : '' ?>"
                              placeholder="Your json here..."></textarea>
                </div>
                <?php if (isset($errors)): ?>
                    <p class="help is-danger"> <?php echo $errors ?></p>
                <?php endif; ?>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-primary">Submit</button>
                </div>
                <div class="control">
                    <button type="reset" class="button is-link">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</section>