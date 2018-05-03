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