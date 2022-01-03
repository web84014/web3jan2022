<div class="notice e-notice e-notice--dismissible e-notice--extended dl-notice <?php echo esc_attr( $data['class'] ); ?>" id="<?php echo esc_attr( $data['id'] ); ?>" style="<?php echo esc_attr( $data['styles'] );?>" >
    <i class="e-notice__dismiss" role="button" aria-label="Dismiss" tabindex="0"></i>			
    <?php if( !empty($data['logo']) ){?>
    <div class="e-notice__aside">
        <div class="e-notice__icon-wrapper"><img src="<?php echo esc_url($data['logo']); ?>"></div>		
    </div>
    <?php } ?>
    <div class="e-notice__content">
        <?php if( !empty($data['title']) ){ ?>
        <h3><?php echo esc_html($data['title']);?></h3>
        <?php }?>
        <?php if( !empty($data['des']) ){ ?>
        <p><?php echo $data['des'];?></p>
        <?php }
        if( !empty($data['btn_url']) ){
        ?>
        <div class="e-notice__actions">
            <a href="<?php echo esc_url($data['btn_url']);?>" class="e-button e-button e-button--cta dl-button"><span><?php echo $data['btn_txt'];?></span></a>			
        </div>
        <?php }?>
    </div>
</div>