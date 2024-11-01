<div class="psb-effect psb-egeon">
    <div class="psb-social-buttons">
        <?php foreach ($social_buttons as $social_button) : ?>
            <a href="<?php echo $social_button['url']; ?>" class="<?php echo $social_button['class']; ?>" title="Share on <?php echo $social_button['label']; ?>"><i class="fa <?php echo $social_button['icon']; ?>" aria-hidden="true"></i></a>
        <?php endforeach; ?>
    </div>
</div>