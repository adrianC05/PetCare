<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .info-row {
            margin: 15px 0;
            padding: 10px;
            background-color: white;
            border-left: 4px solid #4F46E5;
        }
        .label {
            font-weight: bold;
            color: #4F46E5;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐾 Nueva Cita Agendada</h1>
        </div>
        <div class="content">
            <p>Estimado/a <strong><?php echo e($appointment->mascot->owner->name); ?> <?php echo e($appointment->mascot->owner->lastname); ?></strong>,</p>
            
            <p>Se ha agendado una nueva cita para su mascota:</p>
            
            <div class="info-row">
                <span class="label">Mascota:</span> <?php echo e($appointment->mascot->name); ?>

            </div>
            
            <div class="info-row">
                <span class="label">Fecha y Hora:</span> <?php echo e($appointment->appointment_date->format('d/m/Y H:i')); ?>

            </div>
            
            <div class="info-row">
                <span class="label">Motivo:</span> <?php echo e($appointment->reason); ?>

            </div>
            
            <div class="info-row">
                <span class="label">Veterinario:</span> <?php echo e($appointment->veterinarian->name ?? 'Por asignar'); ?>

            </div>
            
            <div class="info-row">
                <span class="label">Duración estimada:</span> <?php echo e($appointment->duration); ?> minutos
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->notes): ?>
            <div class="info-row">
                <span class="label">Notas:</span> <?php echo e($appointment->notes); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <p style="margin-top: 30px;">Por favor, llegue 10 minutos antes de su cita.</p>
            
            <p>Si necesita cancelar o reprogramar, contáctenos lo antes posible.</p>
        </div>
        
        <div class="footer">
            <p>Este es un correo automático, por favor no responda a este mensaje.</p>
            <p>&copy; <?php echo e(date('Y')); ?> PetCare - Sistema de Gestión Veterinaria</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Stephanie Valencia\PetCare\resources\views/emails/appointment-created.blade.php ENDPATH**/ ?>