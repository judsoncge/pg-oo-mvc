ALTER TABLE `tb_arquivos` CHANGE `NM_TIPO` `DS_TIPO` ENUM('APRESENTAÇÃO','AQUISIÇÃO','COTAÇÃO DE PREÇO','CERTIDÃO NEGATIVA','DESPACHO','MEMORANDO','OFÍCIO','PARECER','PUBLICAÇÃO NO DIÁRIO','RELATÓRIO','RESPOSTA AO INTERESSADO','TERMO DE REFERÊNCIA','CERTIFICADO','CHECKLIST') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_STATUS` `DS_STATUS` ENUM('ATIVO','INATIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_ANEXO` `DS_ANEXO` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_arquivos` CHANGE `DS_STATUS` `DS_STATUS` ENUM('ATIVO','INATIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ATIVO';

ALTER TABLE `tb_arquivos` CHANGE `ID_SERVIDOR_ENVIADO` `ID_SERVIDOR_DESTINO` INT(20) NULL DEFAULT NULL;

ALTER TABLE `tb_servidores` CHANGE `NM_STATUS` `DS_STATUS` ENUM('ATIVO','INATIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ATIVO';

ALTER TABLE `tb_servidores` CHANGE `NM_SERVIDOR` `DS_NOME` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_servidores` CHANGE `CD_SERVIDOR` `DS_CPF` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_servidores` CHANGE `DS_FOTO` `DS_FOTO` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default.jpg';

ALTER TABLE `tb_servidores` CHANGE `DS_FUNCAO` `DS_FUNCAO` ENUM('PROTOCOLO','SUPERINTENDENTE','ASSESSOR TÉCNICO','TÉCNICO ANALISTA','GABINETE','CONTROLADOR','TI','COMUNICAÇÃO','CHEFE DE GABINETE','TÉCNICO ANALISTA CORREÇÃO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `tb_comunicacao` CHANGE `NM_CHAPEU` `DS_CHAPEU` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_TITULO` `DS_TITULO` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_INTERTITULO` `DS_INTERTITULO` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `NM_CREDITOS` `DS_CREDITOS` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `NM_STATUS` `DS_STATUS` ENUM('OCULTADA','PUBLICADA','INATIVA') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_setores` CHANGE `NM_SETOR` `DS_NOME` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_setores` CHANGE `DS_ABREVIACAO` `DS_ABREVIACAO` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_chamados` CHANGE `NM_PROBLEMA` `DS_PROBLEMA` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_NATUREZA` `DS_NATUREZA` ENUM('WORD','EXCEL','POWER POINT','TRELLO','SIAFEM','SIAPI','COMPUTADOR OU PEÇA COM DEFEITO','INTERNET','COMPARTILHAMENTO DE PASTA','IMPRESSORA','PAINEL DE GESTÃO','OUTRO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_STATUS` `DS_STATUS` ENUM('ABERTO','RESOLVIDO','ENCERRADO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `NM_AVALIACAO` `DS_AVALIACAO` ENUM('PÉSSIMO','RUIM','REGULAR','BOM','EXCELENTE','SEM AVALIAÇÃO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `tb_chamados` CHANGE `DS_STATUS` `DS_STATUS` ENUM('ABERTO','RESOLVIDO','ENCERRADO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ABERTO';

ALTER TABLE `tb_chamados` CHANGE `DS_STATUS` `DS_STATUS` ENUM('ABERTO','FECHADO','ENCERRADO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ABERTO';

UPDATE tb_chamados SET DS_STATUS = 'FECHADO' WHERE DS_STATUS = '';

ALTER TABLE `tb_chamados` CHANGE `DS_AVALIACAO` `DS_AVALIACAO` ENUM('PÉSSIMO','RUIM','REGULAR','BOM','EXCELENTE','SEM AVALIAÇÃO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'SEM AVALIAÇÃO';

ALTER TABLE `tb_historico_chamados` CHANGE `NM_MENSAGEM` `TX_MENSAGEM` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_historico_chamados` CHANGE `TX_MENSAGEM` `TX_MENSAGEM` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tb_historico_chamados` CHANGE `ID_CHAMADO` `ID_REFERENTE` INT(20) NOT NULL;

ALTER TABLE `tb_historico_chamados` CHANGE `NM_ACAO` `DS_ACAO` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

UPDATE tb_historico_chamados SET DS_ACAO = 'FECHAMENTO' WHERE DS_ACAO = 'RESOLUÇÃO';

ALTER TABLE `tb_historico_chamados` CHANGE `DS_ACAO` `DS_ACAO` ENUM('ABERTURA','FECHAMENTO','AVALIAÇÃO','ENCERRAMENTO','MENSAGEM') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

UPDATE `tb_historico_chamados` SET TX_MENSAGEM = 'ABRIU UM NOVO CHAMADO' WHERE TX_MENSAGEM = 'SOLICITOU AJUDA';

UPDATE `tb_historico_chamados` SET tx_mensagem = 'FECHOU O CHAMADO' WHERE tx_mensagem = 'RESOLVEU O CHAMADO';

ALTER TABLE `tb_historico_chamados` DROP FOREIGN KEY `tb_historico_chamados_ibfk_1`; ALTER TABLE `tb_historico_chamados` ADD CONSTRAINT `tb_historico_chamados_ibfk_1` FOREIGN KEY (`ID_REFERENTE`) REFERENCES `tb_chamados`(`ID`) ON DELETE CASCADE ON UPDATE RESTRICT;