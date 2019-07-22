<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190719212331 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql("
          INSERT INTO payment_error (id, payment_type_id, code, name, gateway_message, message)
          VALUES 
            (nextval('payment_error_id_seq'), 1, '400', 'Error al validar los datos enviados',
            'Error al validar los datos enviados', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 1, '401', 'Error de autenticación',
            'Error de autenticación, ha ocurrido un error con las llaves utilizadas', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 1, '403', 'Pago Rechazado',
            'Pago Rechazado por el banco', 
            'Lo sentimos, tu tarjeta ha sido rechazada, intenta nuevamente con otra tarjeta o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 1, '500', 'Error del servidor',
            'Ha Ocurrido un error interno dentro del servidor', 
            'No hemos podido establecer comunicación con el banco, por favor intenta más tarde'),
            (nextval('payment_error_id_seq'), 1, '503', 'Error al procesar',
            'Ha Ocurrido un error interno dentro del servidor', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 1, '02', 'CEDULA INVALIDA',
            'Cédula inválida', 
            'La cédula de identidad no coincide con el número de tarjeta de crédito, por favor verifica tus datos'),
            (nextval('payment_error_id_seq'), 1, '05', 'TRANS. RECHAZADA',
            'Transacción rechazada', 
            'Lo sentimos, tu tarjeta ha sido rechazada, intenta nuevamente con otra tarjeta o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 1, '06', 'ERROR',
            'Error', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 1, '05', 'TRANS. INVALIDA',
            'Transacción inválida', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 1, '14', 'TARJETA INVALIDA',
            'Tarjeta inválida', 
            'Los datos de tu tarjeta son inválidos, por favor verifícalos o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 1, '41', 'TARJETA EXTRAVIADA',
            'Tarjeta extraviada', 
            'Tarjeta reportada como perdida/robada'),
            (nextval('payment_error_id_seq'), 1, '43', 'TARJETA ROBADA',
            'Tarjeta robada', 
            'Tarjeta reportada como perdida/robada'),
            (nextval('payment_error_id_seq'), 1, '51', 'FONDO INSUFICIENTE',
            'Fondo insuficiente', 
            'La tarjeta que utilizas no cuenta con fondo suficiente. Recarga tu saldo o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 1, '54', 'TARJETA VENCIDA',
            'Tarjeta vencida', 
            'Lo sentimos, tu tarjeta ha caducado'),
            (nextval('payment_error_id_seq'), 1, '79', 'FECHA INVALIDA',
            'Fecha inválida', 
            'La fecha de vencimiento de tu tarjeta no es correcta ¡Verifica tus fatos e intenta colocarla nuevamente!'),
            (nextval('payment_error_id_seq'), 1, '82', 'TARJETA INVALIDA',
            'Tarjeta inválida', 
            'Los datos de tu tarjeta son inválidos, por favor verifícalos o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 1, '99', 'RECHAZADA',
            'Rechazada', 
            'Lo sentimos, tu tarjeta ha sido rechazada, intenta nuevamente con otra tarjeta o realiza una transferencia bancaria');
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DELETE FROM payment_error WHERE payment_type_id = 1');
    }
}
