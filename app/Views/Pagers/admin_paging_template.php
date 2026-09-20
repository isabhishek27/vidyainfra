<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<div class="row">
                    
	<div class="col-sm-12 col-md-5">
		<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing <?php echo $pager->getPerPageStart() ?> to <?php echo $pager->getPerPageEnd() ?>
			of <?php echo $pager->getTotal() ?> results</div>
	</div>
	<div class="col-sm-12 col-md-7">
		<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
			<ul class="pagination">
				<?php if ($pager->hasPreviousPage()) : ?>

				 <li class="paginate_button page-item">
					<a href="<?php echo $pager->getFirst() ?>" class="page-link" aria-label="<?php echo lang('Pager.first') ?>">
						<span aria-hidden="true"><?php echo lang('Pager.first') ?></span>
					</a>
				</li>	
				<li class="paginate_button page-item previous"
					id="DataTables_Table_0_previous">
					<a href="<?php echo $pager->getPreviousPage() ?>" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link" aria-label="<?php echo lang('Pager.next') ?>"><i
							class="ion-chevron-left"></i></a></li>												
				<?php endif ?>
				
				<?php foreach ($pager->links() as $link) : ?>					
					<li class="paginate_button page-item <?php echo $link['active'] ? 'active' : '' ?>"><a href="<?php echo $link['uri'] ?>"
						aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0"
						class="page-link"><?php echo $link['title'] ?></a></li>
				<?php endforeach ?>

				
				<?php if ($pager->hasNextPage()) : ?>	
				<li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="<?php echo $pager->getNextPage() ?>"
						aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0"
						class="page-link"><i class="ion-chevron-right"></i></a></li>
				 <li class="paginate_button page-item">
                <a href="<?php echo $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link">
                    <span aria-hidden="true"><?php echo lang('Pager.last') ?></span>
                </a>
            	</li>		
				<?php endif ?>		
			</ul>
		</div>
	</div>
</div>
