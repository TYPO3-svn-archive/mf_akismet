#
# Table structure for table 'tx_veguestbook_entries'
#
CREATE TABLE tx_veguestbook_entries (
	tx_mfakismet_isspam tinyint(3) DEFAULT '0' NOT NULL,
	tx_mfakismet_error tinytext NOT NULL
);