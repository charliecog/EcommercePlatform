LOCK TABLES `category` WRITE;

INSERT INTO `category` (`id`, `name`)
VALUES
	(1,'Science fiction'),
	(2,'Satire'),
	(3,'Drama'),
	(4,'Action and Adventure'),
	(5,'Romance'),
	(6,'Mystery'),
	(7,'Horror'),
	(8,'Self help'),
	(9,'Health'),
	(10,'Guide'),
	(11,'Travel'),
	(12,'Children\'s'),
	(13,'Religion, Spirituality & New Age'),
	(14,'Science'),
	(15,'History'),
	(16,'Math'),
	(17,'Anthology'),
	(18,'Poetry'),
	(19,'Encyclopedias'),
	(20,'Dictionaries'),
	(21,'Comics'),
	(22,'Art'),
	(23,'Cookbooks'),
	(24,'Diaries'),
	(25,'Journals'),
	(26,'Series'),
	(27,'Biographies'),
	(28,'Autobiographies'),
	(29,'Fantasy');

UNLOCK TABLES;

LOCK TABLES `format` WRITE;

INSERT INTO `format` (`id`, `name`)
VALUES
	(1,'hardcover'),
	(2,'paperback');

UNLOCK TABLES;

LOCK TABLES `book` WRITE;

INSERT INTO `book` (`id`, `title`, `author`, `description`, `format_id`, `year_published`, `publisher`, `image`, `cost_price`, `sell_price`, `stock_level`, `notes`, `featured`, `date_created`, `date_modified`)
VALUES
	(1,'The Martian','Andy Weir','Robinson Crusoe on Mars - a survival story for the 21st Century',2,2015,'Del Rey','11-03-2016_09:35:29.jpg',0.00,3.85,8,'',1,'2016-03-07 15:05:13','2016-03-11 09:54:35'),
	(2,'The Man in the High Castle','Philip K. Dick','Philip K. Dick\'s acclaimed cult novel gives us a horrifying glimpse of an alternative world - one where the Allies have lost the Second World War. In this nightmare dystopia the Nazis have taken over New York, the Japanese control California and the African continent is virtually wiped out. In a neutral buffer zone in America that divides the world\'s new rival superpowers, lives the author of an underground bestseller. His book offers a new vision of reality - an alternative theory of world history in which the Axis powers were defeated - giving hope to the disenchanted. Does \'reality\' lie with him, or is his world just one among many others?',1,2015,'Penguin Classics','11-03-2016_09:36:09.jpg',0.00,4.99,1,'',0,'2016-03-07 15:05:13','2016-03-11 09:44:51'),
	(3,'Slade House','David Mitchell','Turn down Slade Alley - narrow, dank and easy to miss, even when you\'re looking for it. Find the small black iron door set into the right-hand wall. No handle, no keyhole, but at your touch it swings open. Enter the sunlit garden of an old house that doesn\'t quite make sense; too grand for the shabby neighbourhood, too large for the space it occupies.',1,2015,'Sceptre','11-03-2016_09:36:36.jpg',1.00,8.99,3,'',0,'2016-03-07 15:05:13','2016-03-11 09:44:05'),
	(4,'Pride and Prejudice and Zombies','Jane Austen, Seth Grahame-Smith','\"Pride and Prejudice and Zombies\" features the original text of Jane Austen\'s beloved novel with all-new scenes of bone crunching zombie action.',2,2009,'Quirk Books,US','11-03-2016_09:36:52.png',0.00,6.99,5,'',0,'2016-03-07 15:05:13','2016-03-11 09:44:04'),
	(5,'Me Without You','Kelly Rimmer','A story of how love can break our hearts â€“ and heal them.',2,2014,'Bookouture','11-03-2016_09:37:05.jpg',0.00,7.49,4,'',0,'2016-03-07 15:05:13','2016-03-11 09:44:03'),
	(6,'Me Before You','Jojo Moyes','Lou Clark knows lots of things. She knows how many footsteps there are between the bus stop and home. She knows she likes working in The Buttered Bun tea shop and she knows she might not love her boyfriend Patrick.',2,2012,'Michael Joseph','11-03-2016_09:37:20.png',0.00,4.99,5,'',1,'2016-03-07 15:05:13','2016-03-11 09:54:10'),
	(7,'Minions Volume 1- Banana','Didier Ah-Koon, Renaud Collin','Prepare for Minion Madness. From the creators of Despicable Me comes a brand new movie adventure in yellow... Minions. This fresh new comic featuring the stars of the upcoming movie brings together a collection of hilarious comic stories featuring everyone s favourite yellow, banana-loving henchmen. They re the most loveable evil henchmen ever created... Stuart, Kevin, Bob and the rest of the Minions return for laughs and gags in this all-new hilarious comic collection. From bananas to basketball, laugh along as the Minions unleash their unique brand of mayhem on the world once again.',2,2015,'Titan Comics','11-03-2016_09:37:37.jpg',0.00,4.99,1,'',0,'2016-03-07 15:05:13','2016-03-11 09:44:01'),
	(8,'Secret Wars','Jonathan Hickman, Esad Ribic, Paul Renaud','The interdimensional Incursions have eliminated each and every dimension one by one - and now, despite the best efforts of the scientists, sages and superhumans of both dimensions, the Marvel Universe and Ultimate Universe have collided with one another... and been destroyed! Now, all that exists in the vast empty cosmos is a single titanic patchwork planet, made of the fragmented remains of hundreds of devastated dimensions: Battleworld! And the survivors of this multiversal catastrophe must learn to survive in this strange new realm! Collecting: Secret Wars 0-8',1,2016,'Marvel - US','11-03-2016_09:37:53.jpg',0.00,24.69,5,'',1,'2016-03-07 15:05:13','2016-03-11 09:55:10'),
	(9,'A Knight of the Seven Kingdoms (Song of Ice & Fire Prequel)','George R. R. Martin','A century before A GAME OF THRONES, two unlikely heroes wandered Westerosâ€¦\r\n\r\nA KNIGHT OF THE SEVEN KINGDOMS compiles the first three official prequel novellas to George R.R. Martinâ€™s ongoing masterwork, A SONG OF ICE AND FIRE.',1,2015,'Harper Voyager','11-03-2016_09:38:11.jpg',0.00,9.00,1,'',0,'2016-03-07 15:05:13','2016-03-11 09:08:27'),
	(10,'The Dragon Stone Trilogy','Kristian Alva','Complete Box Set: Book One: Dragon Stones, Book Two: Return of the Dragon Riders, Book Three: Vosper\'s Revenge',2,2016,'Defiant Press','11-03-2016_09:51:07.png',0.00,13.99,0,'',0,'2016-03-07 15:05:13','2016-03-11 09:21:23'),
	(11,'The Revenant','Michael Punke ','Rocky Mountains, 1823\r\n\r\nThe trappers of the Rocky Mountain Fur Company live a brutal frontier life. Hugh Glass is one of the most respected men in the company, an experienced frontiersman and an expert tracker.\r\nBut when a scouting mission puts Glass face-to-face with a grizzly bear, he is viciously mauled and not expected to survive. Two men from the company are ordered to remain with him until his inevitable death. But, fearing an imminent attack, they abandon Glass, stripping him of his prized rifle and hatchet.',1,2015,'','11-03-2016_09:51:46.png',0.00,9.45,1,'',1,'2016-03-07 15:05:13','2016-03-11 09:53:43'),
	(12,'The Martian','Andy Weir','Robinson Crusoe on Mars - a survival story for the 21st Century',1,2015,'Del Rey','11-03-2016_09:35:29.jpg',0.00,6.00,4,'',0,'2016-03-07 15:05:13','2016-03-11 09:26:03'),
	(13,'The Man in the High Castle','Philip K. Dick','Philip K. Dick\'s acclaimed cult novel gives us a horrifying glimpse of an alternative world - one where the Allies have lost the Second World War. In this nightmare dystopia the Nazis have taken over New York, the Japanese control California and the African continent is virtually wiped out. In a neutral buffer zone in America that divides the world\'s new rival superpowers, lives the author of an underground bestseller. His book offers a new vision of reality - an alternative theory of world history in which the Axis powers were defeated - giving hope to the disenchanted. Does \'reality\' lie with him, or is his world just one among many others?',2,2015,'Penguin Classics','11-03-2016_09:36:09.jpg',0.00,3.79,6,'',1,'2016-03-07 15:05:13','2016-03-11 09:53:33'),
	(14,'Slade House','David Mitchell','Turn down Slade Alley - narrow, dank and easy to miss, even when you\'re looking for it. Find the small black iron door set into the right-hand wall. No handle, no keyhole, but at your touch it swings open. Enter the sunlit garden of an old house that doesn\'t quite make sense; too grand for the shabby neighbourhood, too large for the space it occupies.',2,2015,'Sceptre','11-03-2016_09:36:36.jpg',1.00,4.99,9,'',0,'2016-03-07 15:05:13','2016-03-11 09:25:25'),
	(15,'Pride and Prejudice and Zombies','Jane Austen, Seth Grahame-Smith','\"Pride and Prejudice and Zombies\" features the original text of Jane Austen\'s beloved novel with all-new scenes of bone crunching zombie action.',1,2009,'Quirk Books,US','11-03-2016_09:36:52.png',0.00,7.45,2,'',0,'2016-03-07 15:05:13','2016-03-11 09:27:19'),
	(16,'Me Without You','Kelly Rimmer','A story of how love can break our hearts â€“ and heal them.',1,2014,'Bookouture','11-03-2016_09:37:05.jpg',0.00,11.00,2,'',0,'2016-03-07 15:05:13','2016-03-11 09:26:53'),
	(17,'Me Before You','Jojo Moyes','Lou Clark knows lots of things. She knows how many footsteps there are between the bus stop and home. She knows she likes working in The Buttered Bun tea shop and she knows she might not love her boyfriend Patrick.',1,2012,'Michael Joseph','11-03-2016_09:37:20.png',0.00,6.99,0,'',0,'2016-03-07 15:05:13','2016-03-11 09:26:33'),
	(18,'Minions Volume 1- Banana','Didier Ah-Koon, Renaud Collin','Prepare for Minion Madness. From the creators of Despicable Me comes a brand new movie adventure in yellow... Minions. This fresh new comic featuring the stars of the upcoming movie brings together a collection of hilarious comic stories featuring everyone s favourite yellow, banana-loving henchmen. They re the most loveable evil henchmen ever created... Stuart, Kevin, Bob and the rest of the Minions return for laughs and gags in this all-new hilarious comic collection. From bananas to basketball, laugh along as the Minions unleash their unique brand of mayhem on the world once again.',1,2015,'Titan Comics','11-03-2016_09:37:37.jpg',0.00,5.99,0,'',1,'2016-03-07 15:05:13','2016-03-11 09:52:57'),
	(19,'Secret Wars','Jonathan Hickman, Esad Ribic, Paul Renaud','The interdimensional Incursions have eliminated each and every dimension one by one - and now, despite the best efforts of the scientists, sages and superhumans of both dimensions, the Marvel Universe and Ultimate Universe have collided with one another... and been destroyed! Now, all that exists in the vast empty cosmos is a single titanic patchwork planet, made of the fragmented remains of hundreds of devastated dimensions: Battleworld! And the survivors of this multiversal catastrophe must learn to survive in this strange new realm! Collecting: Secret Wars 0-8',2,2016,'Marvel - US','11-03-2016_09:37:53.jpg',0.00,14.99,0,'',0,'2016-03-07 15:05:13','2016-03-11 09:25:40'),
	(20,'A Knight of the Seven Kingdoms (Song of Ice & Fire Prequel)','George R. R. Martin','A century before A GAME OF THRONES, two unlikely heroes wandered Westerosâ€¦\r\n\r\nA KNIGHT OF THE SEVEN KINGDOMS compiles the first three official prequel novellas to George R.R. Martinâ€™s ongoing masterwork, A SONG OF ICE AND FIRE.',2,2015,'Harper Voyager','11-03-2016_09:38:11.jpg',0.00,6.55,6,'',0,'2016-03-07 15:05:13','2016-03-11 09:27:14'),
	(21,'The Dragon Stone Trilogy','Kristian Alva','Complete Box Set: Book One: Dragon Stones, Book Two: Return of the Dragon Riders, Book Three: Vosper\'s Revenge',1,2016,'Defiant Press','11-03-2016_09:51:07.png',0.00,18.49,3,'',0,'2016-03-07 15:05:13','2016-03-11 09:26:43'),
	(22,'The Revenant','Michael Punke ','Rocky Mountains, 1823\r\n\r\nThe trappers of the Rocky Mountain Fur Company live a brutal frontier life. Hugh Glass is one of the most respected men in the company, an experienced frontiersman and an expert tracker.\r\nBut when a scouting mission puts Glass face-to-face with a grizzly bear, he is viciously mauled and not expected to survive. Two men from the company are ordered to remain with him until his inevitable death. But, fearing an imminent attack, they abandon Glass, stripping him of his prized rifle and hatchet.',2,2015,'','11-03-2016_09:51:46.png',0.00,5.25,0,'',0,'2016-03-07 15:05:13','2016-03-11 09:25:53'),
	(23,'Behind Closed Doors','B A Paris','The perfect marriage? Or the perfect lie?\r\nThe debut psychological thriller you canâ€™t miss!',2,2016,'MIRA','11-03-2016_09:52:20.png',0.00,3.99,3,'',1,'2016-03-11 07:40:15','2016-03-11 09:52:30'),
	(24,'Behind Closed Doors','B A Paris','The perfect marriage? Or the perfect lie?\r\nThe debut psychological thriller you canâ€™t miss!',1,2016,'MIRA','11-03-2016_09:53:00.jpg',0.00,4.59,1,'',0,'2016-03-11 07:40:53','2016-03-11 09:24:51'),
	(25,'Make Me: (Jack Reacher 20)','Lee Child','Jack Reacher has no place to go, and all the time in the world to get there, so a remote railroad stop on the prairie with the curious name of Mother\'s Rest seems perfect for an aimless one-day stopover. He expects to find a lonely pioneer tombstone in a sea of nearly-ripe wheat ... but instead there is a woman waiting for a missing colleague, a cryptic note about two hundred deaths, and a small town full of silent, watchful people.',2,2016,'Bantam','11-03-2016_09:52:38.png',0.00,3.99,4,'',0,'2016-03-11 07:52:24','2016-03-11 09:43:58'),
	(26,'Make Me: (Jack Reacher 20)','Lee Child','Jack Reacher has no place to go, and all the time in the world to get there, so a remote railroad stop on the prairie with the curious name of Mother\'s Rest seems perfect for an aimless one-day stopover. He expects to find a lonely pioneer tombstone in a sea of nearly-ripe wheat ... but instead there is a woman waiting for a missing colleague, a cryptic note about two hundred deaths, and a small town full of silent, watchful people.',1,2016,'Bantam','11-03-2016_09:52:38.png',0.00,5.00,0,'',0,'2016-03-11 07:52:24','2016-03-11 09:25:13'),
	(27,'The Scrapbook of My Life',' Alfie Deyes','Inside this book you\'ll read all about the day I was born and what it was like growing up with my family in Brighton. Read stories from my childhood and teen years, right up until present day, and, of course, all about how my crazy YouTube journey began and my thoughts on what the future holds. I\'ve had some amazing adventures and met some awesome people along the way, and like everything I do I wanted to share it all with you. ',2,2016,'Blink Publishing','11-03-2016_09:53:00.jpg',0.00,9.99,2,'',0,'2016-03-11 08:08:23','2016-03-11 09:23:16'),
	(28,'A Darker Shade of Magic','V. E. Schwab, Victoria Schwab','Most people only know one London; but what if there were several? Kell is one of the last Travelers magicians with a rare ability to travel between parallel Londons. There is Grey London, dirty and crowded and without magic, home to the mad king George III. There is Red London, where life and magic are revered. Then, White London, ruled by whoever has murdered their way to the throne. But once upon a time, there was Black London...',2,2015,'Titan Books','11-03-2016_09:53:43.jpg',0.00,5.99,4,'',1,'2016-03-11 08:53:13','2016-03-11 09:54:51'),
	(29,'A Darker Shade of Magic','V. E. Schwab, Victoria Schwab','Most people only know one London; but what if there were several? Kell is one of the last Travelers magicians with a rare ability to travel between parallel Londons. There is Grey London, dirty and crowded and without magic, home to the mad king George III. There is Red London, where life and magic are revered. Then, White London, ruled by whoever has murdered their way to the throne. But once upon a time, there was Black London...',1,2015,'Titan Books','11-03-2016_09:53:43.jpg',0.00,10.99,1,'',0,'2016-03-11 08:59:18','2016-03-11 09:24:43'),
	(30,'A Gathering of Shadows','V. E. Schwab, Victoria Schwab','Kell is one of the last magicians with the ability to travel between parallel universes, linked by the magical city of London. It has been four months since a mysterious obsidian stone fell into his possession and he met Delilah Bard. Four months since the Dane twins of White London fell, and the stone was cast with Holland\'s dying body back into Black London. Now Kell is visited by dreams of ominous magical events, waking only to think of Lila. And as Red London prepares for the Element Games an international competition of magic a certain pirate ship draws closer. But another London is coming back to life. The balance of magic is perilous, and for one city to flourish, another must fall...',2,2016,'Titan Books','11-03-2016_10:00:29.jpg',0.00,6.99,6,'',0,'2016-03-11 09:30:45','2016-03-11 09:30:45'),
	(31,'Cure: A Journey Into the Science of Mind over Body','Jo Marchant','The field of mind-body medicine is plagued by wild claims that mislead patients and instil false hope. But as scientists in a range of fields uncover solid evidence that our minds influence our bodies far more profoundly than previously thought, there is now great promise too.',1,2016,'Canongate Books','11-03-2016_10:03:42.jpg',0.00,12.00,2,'',1,'2016-03-11 09:33:58','2016-03-11 09:53:30'),
	(32,'The Chimp Paradox: The Mind Management Programme to Help You Achieve Success, Confidence and Happiness','Prof Steve Peters','The Chimp Paradox is an incredibly powerful mind management model that can help you become a happy, confident, healthier and more successful person. Prof Steve Peters explains the struggle that takes place within your mind and then shows how to apply this understanding to every area of your life so you can:\n\n- Recognise how your mind is working\n- Understand and manage your emotions and thoughts\n- Manage yourself and become the person you would like to be\n',2,2012,'Vermilion','11-03-2016_09:39:11.jpg',0.00,9.09,4,'',1,'2016-03-11 10:21:18','2016-03-11 10:21:18');

UNLOCK TABLES;

LOCK TABLES `book_category` WRITE;

INSERT INTO `book_category` (`id`, `book_id`, `category_id`)
VALUES
	(1,1,1),
	(2,2,1),
	(3,3,7),
	(4,4,7),
	(5,5,5),
	(6,6,5),
	(7,7,21),
	(8,8,21),
	(9,9,29),
	(10,10,29),
	(11,11,4),
	(12,12,1),
	(13,13,1),
	(14,14,7),
	(15,15,7),
	(16,16,5),
	(17,17,5),
	(18,18,21),
	(19,19,21),
	(20,20,29),
	(21,21,29),
	(22,22,4),
	(23,23,6),
	(24,24,6),
	(25,25,26),
	(26,26,26),
	(27,27,27),
	(28,28,29),
	(29,29,29),
	(30,30,29),
	(31,31,14),
	(32,32,8);

UNLOCK TABLES;