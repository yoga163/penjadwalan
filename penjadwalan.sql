/*
 Navicat Premium Data Transfer

 Source Server         : Project
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : penjadwalan

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 24/01/2023 23:28:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin@mail.com', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Administrator', 1);

-- ----------------------------
-- Table structure for data_jadwal
-- ----------------------------
DROP TABLE IF EXISTS `data_jadwal`;
CREATE TABLE `data_jadwal`  (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `mapel` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hari` date NULL DEFAULT NULL,
  `jam` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_mulai` date NULL DEFAULT NULL,
  `tgl_selesai` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2374 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_jadwal
-- ----------------------------
INSERT INTO `data_jadwal` VALUES (2363, 'MTK', '2023-01-19', 'J003', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2364, 'IPA', '2023-01-17', 'J001', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2365, 'IPS', '2023-01-20', 'J002', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2366, 'PKN', '2023-01-18', 'J001', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2367, 'AGM', '2023-01-16', 'J001', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2368, 'BIND', '2023-01-20', 'J002', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2369, 'BING', '2023-01-19', 'J002', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2370, 'MLK', '2023-01-19', 'J001', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2371, 'SB', '2023-01-17', 'J001', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2372, 'FSK', '2023-01-16', 'J003', '2023-01-16', '2023-01-20');
INSERT INTO `data_jadwal` VALUES (2373, 'BIO', '2023-01-20', 'J001', '2023-01-16', '2023-01-20');

-- ----------------------------
-- Table structure for data_pengawas
-- ----------------------------
DROP TABLE IF EXISTS `data_pengawas`;
CREATE TABLE `data_pengawas`  (
  `id_pengawas` int NOT NULL AUTO_INCREMENT,
  `guru` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ruang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengawas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_pengawas
-- ----------------------------
INSERT INTO `data_pengawas` VALUES (53, 'ASD2', 'QW1');
INSERT INTO `data_pengawas` VALUES (54, 'ASD3', 'QW1');
INSERT INTO `data_pengawas` VALUES (55, 'ASD1', 'QW2');
INSERT INTO `data_pengawas` VALUES (56, 'ASD3', 'QW2');

-- ----------------------------
-- Table structure for data_waktu
-- ----------------------------
DROP TABLE IF EXISTS `data_waktu`;
CREATE TABLE `data_waktu`  (
  `id_waktu` int NOT NULL AUTO_INCREMENT,
  `kode_waktu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hari` int NULL DEFAULT NULL,
  `jam` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_waktu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_waktu
-- ----------------------------

-- ----------------------------
-- Table structure for master_guru
-- ----------------------------
DROP TABLE IF EXISTS `master_guru`;
CREATE TABLE `master_guru`  (
  `id_guru` int NOT NULL AUTO_INCREMENT,
  `kode_guru` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_guru`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_guru
-- ----------------------------
INSERT INTO `master_guru` VALUES (6, 'ASD1', 'Ada');
INSERT INTO `master_guru` VALUES (7, 'ASD2', 'Wahyu');
INSERT INTO `master_guru` VALUES (8, 'ASD3', 'Tiko');

-- ----------------------------
-- Table structure for master_jam
-- ----------------------------
DROP TABLE IF EXISTS `master_jam`;
CREATE TABLE `master_jam`  (
  `id_jam` int NOT NULL AUTO_INCREMENT,
  `kode_jam` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jam_mulai` time NULL DEFAULT NULL,
  `jam_selesai` time NULL DEFAULT NULL,
  PRIMARY KEY (`id_jam`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_jam
-- ----------------------------
INSERT INTO `master_jam` VALUES (1, 'J001', '07:30:00', '09:00:00');
INSERT INTO `master_jam` VALUES (2, 'J002', '09:30:00', '11:00:00');
INSERT INTO `master_jam` VALUES (3, 'J003', '11:30:00', '13:00:00');

-- ----------------------------
-- Table structure for master_kelas
-- ----------------------------
DROP TABLE IF EXISTS `master_kelas`;
CREATE TABLE `master_kelas`  (
  `id_kelas` int NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hari` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kondisi` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kelas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_kelas
-- ----------------------------
INSERT INTO `master_kelas` VALUES (1, 'SMK1', 'XII', '1;2;3;4;5', 'GROUP');
INSERT INTO `master_kelas` VALUES (2, 'SMK2', 'XI', '1;2;3;4;5', 'GROUP');
INSERT INTO `master_kelas` VALUES (3, 'SMK3', 'X', '1;2;3;4;5', 'GROUP');
INSERT INTO `master_kelas` VALUES (12, 'SMK4', 'XIII', NULL, 'Group');

-- ----------------------------
-- Table structure for master_mapel
-- ----------------------------
DROP TABLE IF EXISTS `master_mapel`;
CREATE TABLE `master_mapel`  (
  `id_mapel` int NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_mapel`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_mapel
-- ----------------------------
INSERT INTO `master_mapel` VALUES (2, 'MTK', 'Matematika');
INSERT INTO `master_mapel` VALUES (3, 'IPA', 'Ilmu Pengetahuan Alam');
INSERT INTO `master_mapel` VALUES (4, 'IPS', 'Ilmu Pengetahuan Sosial');
INSERT INTO `master_mapel` VALUES (5, 'PKN', 'Pendidikan Kewarganegaraan');
INSERT INTO `master_mapel` VALUES (6, 'AGM', 'Agama');
INSERT INTO `master_mapel` VALUES (7, 'BIND', 'Bahasa Indonesia');
INSERT INTO `master_mapel` VALUES (8, 'BING', 'Bahasa Inggris');
INSERT INTO `master_mapel` VALUES (9, 'MLK', 'Muatan Lokal');
INSERT INTO `master_mapel` VALUES (10, 'SB', 'Seni Budaya');
INSERT INTO `master_mapel` VALUES (11, 'FSK', 'Fisika');
INSERT INTO `master_mapel` VALUES (12, 'BIO', 'Biologi');

-- ----------------------------
-- Table structure for master_ruang
-- ----------------------------
DROP TABLE IF EXISTS `master_ruang`;
CREATE TABLE `master_ruang`  (
  `id_ruang` int NOT NULL AUTO_INCREMENT,
  `kode_ruang` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_ruang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_ruang
-- ----------------------------
INSERT INTO `master_ruang` VALUES (7, 'QW2', 'Kelas 2');
INSERT INTO `master_ruang` VALUES (8, 'QW1', 'Kelas 1');

SET FOREIGN_KEY_CHECKS = 1;
