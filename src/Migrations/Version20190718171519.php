<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190718171519 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql("
          INSERT INTO payment_error (id, payment_type_id, code, name, gateway_message, message)
          VALUES 
            (nextval('payment_error_id_seq'), 6, 99, 'Default error',
            'Default message', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 6, 201, 'Invalid CC Number',
            'Bad check digit, length, or other credit card problem', 
            'Los datos de tu tarjeta son inválidos, por favor verifícalos o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 6, 202, 'Bad Amount Nonnumeric Amount',
            'Amount sent was zero, unreadable, over ceiling limit, or exceeds maximum allowable amount', 
            'La cantidad enviada fue cero, ilegible, por encima del límite máximo, o excede la cantidad máxima permitida'),
            (nextval('payment_error_id_seq'), 6, 203, 'Zero Amount',
            'Amount sent was zero', 
            'La cantidad enviada fue cero'),
            (nextval('payment_error_id_seq'), 6, 225, 'Invalid Field Data',
            'Data within transaction is incorrect', 
            'Los datos dentro de la transacción son incorrectos'),
            (nextval('payment_error_id_seq'), 6, 241, 'Illegal Action',
            'Invalid action attempted', 
            'Acción inválida'),
            (nextval('payment_error_id_seq'), 6, 242, 'Invalid Temporary Services Data',
            'Invalid Temporary Services Data', 
            'Los datos son inexactos o faltan'),
            (nextval('payment_error_id_seq'), 6, 272, 'Invalid Purchase Level 2',
            'Purchase card data is inaccurate or missing, or not an appropriate card brand.', 
            'Los datos de tu tarjeta son inválidos, por favor verifícalos o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 6, 274, 'Transaction Not Supported',
            'The requested transaction type is blocked from being used with this card', 
            'El tipo de transacción solicitada está bloqueada para que no se use con esta tarjeta'),
            (nextval('payment_error_id_seq'), 6, 299, 'Duplicate Transaction',
            'The transaction is a duplicate of a previous transaction (either within this same batch file, or in any batch file submitted by the client in the last 7 days).', 
            'La transacción es un duplicado de una transacción anterior'),
            (nextval('payment_error_id_seq'), 6, 301, 'Issuer unavailable',
            'Authorization network could not reach the bank which issued the card', 
            'No hemos podido establecer comunicación con el banco, por favor intenta más tarde'),
            (nextval('payment_error_id_seq'), 6, 302, 'Credit Floor',
            'Insufficient funds', 
            'La tarjeta que utilizas no cuenta con fondo suficiente. Recarga tu saldo o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 6, 420, 'Unsupported Currency',
            'A transaction has been attempted in an invalid currency, or one not supported by the endpoint', 
            'Se ha intentado realizar una transacción en una moneda no válida, o una no es compatible con el punto final'),
            (nextval('payment_error_id_seq'), 6, 502, 'Lost/Stolen',
            'Card reported as lost/stolen', 
            'Tarjeta reportada como perdida/robada'),
            (nextval('payment_error_id_seq'), 6, 503, 'Fraud/Security Violation',
            'CID did not match', 
            'CID no coincide'),
            (nextval('payment_error_id_seq'), 6, 508, 'Excessive PIN try',
            'Allowable number of PIN tries exceeded', 
            'Número de intentos de PIN permitidos excedido'),
            (nextval('payment_error_id_seq'), 6, 509, 'Over the limit',
            'Exceeds withdrawal or activity amount limit', 
            'Supera el límite de retiro o de actividad'),
            (nextval('payment_error_id_seq'), 6, 510, 'Over Limit Frequency',
            'Exceeds withdrawal or activity amount limit', 
            'Supera el límite de retiro o de actividad'),
            (nextval('payment_error_id_seq'), 6, 521, 'Insufficient funds',
            'Insufficient funds/over credit limit', 
            'La tarjeta que utilizas no cuenta con fondo suficiente. Recarga tu saldo o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 6, 522, 'Card is expired ',
            'Card has expired', 
            'Lo sentimos, tu tarjeta ha caducado'),
            (nextval('payment_error_id_seq'), 6, 530, 'Do Not Honor',
            'Generic Decline', 
            'Lo sentimos, tu tarjeta ha sido rechazada, intenta nuevamente con otra tarjeta o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 6, 531, 'CVV2/VAK Failure',
            'Issuer has declined auth request because CVV2 or VAK failed', 
            'El código CVV parece no estar correcto ¡Intenta colocarlo de nuevo!'),
            (nextval('payment_error_id_seq'), 6, 546, 'Blocked Account',
            'Transaction Blocked for Risk', 
            'Transacción bloqueada'),
            (nextval('payment_error_id_seq'), 6, 551, 'Duplicate Transaction',
            'Duplicate Transaction Detected', 
            'Transacción duplicada'),
            (nextval('payment_error_id_seq'), 6, 591, 'Invalid CC Number',
            'Bad check digit, length or other credit card problem', 
            'Los datos de tu tarjeta son inválidos, por favor verifícalos o realiza una transferencia bancaria'),
            (nextval('payment_error_id_seq'), 6, 594, 'Other Error',
            'Unidentifiable error', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 6, 596, 'Suspected Fraud',
            'Issuer has flagged account as suspected fraud', 
            'El emisor ha marcado la cuenta como sospechoso de fraude'),
            (nextval('payment_error_id_seq'), 6, 606, 'Invalid Transaction Type',
            'Issuer does not allow this type of transaction', 
            'El emisor no permite este tipo de transacción'),
            (nextval('payment_error_id_seq'), 6, 806, 'Restraint',
            'Card has been restricted', 
            'La tarjeta ha sido restringida'),
            (nextval('payment_error_id_seq'), 6, 811, 'Invalid Security Code',
            'American Express CID is incorrect', 
            'El código CID parece no estar correcto ¡Intenta colocarlo de nuevo!'),
            (nextval('payment_error_id_seq'), 6, 833, 'Invalid Merchant',
            'Service Established (SE) number is incorrect, closed or Issuer does not allow this type of transaction', 
            'No pudimos procesar tu solicitud, por favor intenta nuevamente'),
            (nextval('payment_error_id_seq'), 6, 903, 'Invalid Expiration',
            'Invalid or expired expiration date', 
            'La fecha de vencimiento de tu tarjeta no es correcta ¡Verifica tus fatos e intenta colocarla nuevamente!'),
            (nextval('payment_error_id_seq'), 6, 904, 'Invalid Effective',
            'Card not active', 
            'Por favor, conmunícate con tu banco y activa tu tarjeta para transacciones electrónicas');
        ");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DELETE FROM payment_error WHERE payment_type_id = 6');

    }
}
