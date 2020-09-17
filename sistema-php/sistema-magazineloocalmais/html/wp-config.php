<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'wp-dados' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'admin' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '1KtbGq1q' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'e@];!y6{+PYePQ1{ytFZZtmLj7/P}AH]$_M[y{8l]}g~lKVq-hR;x]HQU<a0mFH.' );
define( 'SECURE_AUTH_KEY',  '4Ep61baDRB^2}O()0w<nXBi1FO*BJd P`ifM|N#(Ak*`9X:dXLhdBDuK.M.#hEtf' );
define( 'LOGGED_IN_KEY',    '!mD$/8|_6!^(KI!v5Jgqm!2?QDKaqA9-],1 w=n93rd`r#|:wPG=&=NdjVQA^l!{' );
define( 'NONCE_KEY',        'O:Sqg&*nZg;9UL2YNC4YZ^gU#%qrTm&0?yu|#@l hys7::JOdn`ob34q!v =inh*' );
define( 'AUTH_SALT',        '?Nj2XeU0_bamy*LW c^+d-^IqHL2sIY =5Rs@JOq)~dj>yH]t.Kh!bL9d@]2Of6|' );
define( 'SECURE_AUTH_SALT', 'FO*fzEs?25F 0(9b(AQ/Y{U>F:tDd^bkM9yWZq9D9#)L2aft]Y#acmW>mTMx:`K=' );
define( 'LOGGED_IN_SALT',   'Q>y9<hXhz:.p><bNOUf*~%KT+,D:- H_$gUDeC_kGA,N1ORfiXn]xFk(byX(<z9K' );
define( 'NONCE_SALT',       'G:;7HV`YL&wIO$$9sOIq3e%wLr`5ESwqPd>/+7_d0~?1fT6!OEqD95.b.[uh3JRf' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
