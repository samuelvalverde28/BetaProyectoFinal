<?php $__env->startSection('content'); ?>
<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header centrado">
          <h2><i class="fas fa-angle-double-right"></i> Bienvenido <?php echo e(Auth::user()->name); ?> <i
              class="fas fa-angle-double-left"></i></h2>
        </div>
        <div class="card-body">
          <div class="centrado">

            <?php
              $jugando = 0;
              $completado = 0;
              $dejado = 0;
              $espera = 0;
              $total = 0;

              foreach ($Usersgame as $us) {
                $total++;

                switch ($us->estado) {
                  case 'jugando':
                    $jugando++;
                    break;
                  case 'completado':
                    $completado++;
                    break;
                  case 'espera':
                    $espera++;
                    break;
                  case 'dejado':
                    $dejado++;
                    break;
                }

              }

              if ($total == 0) {
                $porJugando = 0;
                $porCompletado = 0;
                $porEspera = 0;
                $porDejado = 0;
              } else{
                $porJugando = 100*$jugando/$total;
                $porCompletado = 100*$completado/$total;
                $porEspera = 100*$espera/$total;
                $porDejado = 100*$dejado/$total;
              }

              

            ?>




            <div>Jugando</div>
            <div class="progress progreso">
              
              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($porJugando); ?>%" aria-valuenow="25"
              aria-valuemin="0" aria-valuemax="100"><?php echo e($jugando); ?>/<?php echo e($total); ?></div>
            </div>

            <div>Completado</div>
            <div class="progress progreso">
              <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($porCompletado); ?>%" aria-valuenow="50"
                aria-valuemin="0" aria-valuemax="100"><?php echo e($completado); ?>/<?php echo e($total); ?></div>
            </div>

            <div>Espera</div>
            <div class="progress progreso">
              <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($porEspera); ?>%" aria-valuenow="75"
                aria-valuemin="0" aria-valuemax="100"><?php echo e($espera); ?>/<?php echo e($total); ?></div>
            </div>


            <div>Dejado</div>
            <div class="progress progreso">
              <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo e($porDejado); ?>%" aria-valuenow="100"
                aria-valuemin="0" aria-valuemax="100"><?php echo e($dejado); ?>/<?php echo e($total); ?></div>
            </div>
          </div>



        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PlayGaming\resources\views/home.blade.php ENDPATH**/ ?>