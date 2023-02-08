const dropdownOptions = [
{ label: 'Address Book', value: 'fa fa-address-book' },
{ label: 'Address Book Outline', value: 'fa fa-address-book-o' },
{ label: 'Address Card', value: 'fa fa-address-card' },
{ label: 'Address Card Outline', value: 'fa fa-address-card-o' },
{ label: 'Adjust Circle half-filled', value: 'fa fa-adjust' },
{ label: 'Align Center', value: 'fa fa-align-center' },
{ label: 'Align Justify', value: 'fa fa-align-justify' },
{ label: 'Align Left', value: 'fa fa-align-left' },
{ label: 'Align Right', value: 'fa fa-align-right' },
{ label: 'Align outdent', value: 'fa fa-outdent' },
{ label: 'Ambulance', value: 'fa fa-ambulance' },
{ label: 'ASL interpreting', value: 'fa fa-american-sign-language-interpreting' },
{ label: 'Anchor', value: 'fa fa-anchor' },
{ label: 'Android logo', value: 'fa fa-android' },
{ label: 'Double angle down', value: 'fa fa-angle-double-down' },
{ label: 'Double angle left', value: 'fa fa-angle-double-left' },
{ label: 'Double angle right', value: 'fa fa-angle-double-right' },
{ label: 'Double angle up', value: 'fa fa-angle-double-up' },
{ label: 'Angle down', value: 'fa fa-angle-down' },
{ label: 'Angle left', value: 'fa fa-angle-left' },
{ label: 'Angle right', value: 'fa fa-angle-right' },
{ label: 'Angle up', value: 'fa fa-angle-up' },
{ label: 'Apple logo', value: 'fa fa-apple' },
{ label: 'Archive', value: 'fa fa-archive' },
{ label: 'Area chart', value: 'fa fa-area-chart' },
{ label: 'Arrow in circle down', value: 'fa fa-arrow-circle-down' },
{ label: 'Arrow in circle left', value: 'fa fa-arrow-circle-left' },
{ label: 'Arrow in circle right', value: 'fa fa-arrow-circle-right' },
{ label: 'Arrow in circle pointing up', value: 'fa fa-arrow-circle-up' },
{ label: 'Arrow in outline circle down', value: 'fa fa-arrow-circle-o-down' },
{ label: 'Arrow in outline circle left', value: 'fa fa-arrow-circle-o-left' },
{ label: 'Arrow in outline circle right', value: 'fa fa-arrow-circle-o-right' },
{ label: 'Arrow in outline circle up', value: 'fa fa-arrow-circle-o-up' },
{ label: 'Long arrow down', value: 'fa fa-long-arrow-down' },
{ label: 'Long arrow left', value: 'fa fa-long-arrow-left' },
{ label: 'Long arrow right', value: 'fa fa-long-arrow-right' },
{ label: 'Long arrow up', value: 'fa fa-long-arrow-up' },
{ label: 'Arrow down', value: 'fa fa-arrow-down' },
{ label: 'Arrow left', value: 'fa fa-arrow-left' },
{ label: 'Arrow right', value: 'fa fa-arrow-right' },
{ label: 'Arrow left and right', value: 'fa fa-arrows-h' },
{ label: 'Arrow up', value: 'fa fa-arrow-up' },
{ label: 'Arrows up down left and right', value: 'fa fa-arrows' },
{ label: 'Arrows diagonal top right and bottom left', value: 'fa fa-expand' },
{ label: 'Arrows diagonal four corners', value: 'fa fa-arrows-alt' },
{ label: 'Arrows criss-crossing', value: 'fa fa-random' },
{ label: 'Arrows left and right', value: 'fa fa-exchange' },
{ label: 'Arrows up and down', value: 'fa fa-arrows-v' },
{ label: 'Reply arrow', value: 'fa fa-reply' },
{ label: 'Reply to all arrows', value: 'fa fa-reply-all' },
{ label: 'Retweet arrows', value: 'fa fa-retweet' },
{ label: 'Share arrow', value: 'fa fa-share' },
{ label: 'Share arrow in square', value: 'fa fa-share-square' },
{ label: 'Share arrow in square outline', value: 'fa fa-share-square-o' },
{ label: 'Sign-in arrow', value: 'fa fa-sign-in' },
{ label: 'Sign-out arrow', value: 'fa fa-sign-out' },
{ label: 'Sort up and down arrows', value: 'fa fa-sort' },
{ label: 'Sort A to Z', value: 'fa fa-sort-alpha-asc' },
{ label: 'Sort Z to A', value: 'fa fa-sort-alpha-desc' },
{ label: 'Sort amount ascending', value: 'fa fa-sort-amount-asc' },
{ label: 'Sort amount descending', value: 'fa fa-sort-amount-desc' },
{ label: 'Sort up', value: 'fa fa-sort-asc' },
{ label: 'Sort down', value: 'fa fa-sort-desc' },
{ label: 'Sort numeric ascending', value: 'fa fa-sort-numeric-asc' },
{ label: 'Sort numeric descending', value: 'fa fa-sort-numeric-desc' },
{ label: 'Undo circular arrow', value: 'fa fa-undo' },
{ label: 'Assistive listening systems', value: 'fa fa-assistive-listening-systems' },
{ label: 'Asterisk', value: 'fa fa-asterisk' },
{ label: 'At', value: 'fa fa-at' },
{ label: 'Audio description', value: 'fa fa-audio-description' },
{ label: 'Ban circle with cross', value: 'fa fa-ban' },
{ label: 'Barcode', value: 'fa fa-barcode' },
{ label: 'Bathtub', value: 'fa fa-bath' },
{ label: 'Battery empty', value: 'fa fa-battery-empty' },
{ label: 'Battery full', value: 'fa fa-battery-full' },
{ label: 'Battery half charged', value: 'fa fa-battery-half' },
{ label: 'Battery one-quarter charged', value: 'fa fa-battery-quarter' },
{ label: 'Battery-three quarters charged', value: 'fa fa-battery-three-quarters' },
{ label: 'Bed', value: 'fa fa-bed' },
{ label: 'Beer', value: 'fa fa-beer' },
{ label: 'Bell', value: 'fa fa-bell' },
{ label: 'Bell outline', value: 'fa fa-bell-o' },
{ label: 'Bell slashed', value: 'fa fa-bell-slash' },
{ label: 'Bell slashed outline', value: 'fa fa-bell-slash-o' },
{ label: 'Bicycle', value: 'fa fa-bicycle' },
{ label: 'Binoculars', value: 'fa fa-binoculars' },
{ label: 'Birthday cake', value: 'fa fa-birthday-cake' },
{ label: 'Black tie', value: 'fa fa-black-tie' },
{ label: 'Blind', value: 'fa fa-blind' },
{ label: 'Bluetooth in oval', value: 'fa fa-bluetooth' },
{ label: 'Bluetooth', value: 'fa fa-bluetooth-b' },
{ label: 'Bold', value: 'fa fa-bold' },
{ label: 'Bolt of lightning', value: 'fa fa-bolt' },
{ label: 'Bomb', value: 'fa fa-bomb' },
{ label: 'Book', value: 'fa fa-book' },
{ label: 'Bookmark', value: 'fa fa-bookmark' },
{ label: 'Bookmark outline', value: 'fa fa-bookmark-o' },
{ label: 'Braille', value: 'fa fa-braille' },
{ label: 'Briefcase', value: 'fa fa-briefcase' },
{ label: 'Bug', value: 'fa fa-bug' },
{ label: 'Building', value: 'fa fa-building' },
{ label: 'Building outline', value: 'fa fa-building-o' },
{ label: 'Bullhorn', value: 'fa fa-bullhorn' },
{ label: 'Bullseye', value: 'fa fa-bullseye' },
{ label: 'Bus', value: 'fa fa-bus' },
{ label: 'Calculator', value: 'fa fa-calculator' },
{ label: 'Calendar', value: 'fa fa-calendar' },
{ label: 'Calendar with checkmark outline', value: 'fa fa-calendar-check-o' },
{ label: 'Calendar with minus outline', value: 'fa fa-calendar-minus-o' },
{ label: 'Calendar outline', value: 'fa fa-calendar-o' },
{ label: 'Calendar with plus outline', value: 'fa fa-calendar-plus-o' },
{ label: 'Calendar with times outline', value: 'fa fa-calendar-times-o' },
{ label: 'Camera', value: 'fa fa-camera' },
{ label: 'Retro Camera', value: 'fa fa-camera-retro' },
{ label: 'Car', value: 'fa fa-car' },
{ label: 'Caret down', value: 'fa fa-caret-down' },
{ label: 'Caret left', value: 'fa fa-caret-left' },
{ label: 'Caret right', value: 'fa fa-caret-right' },
{ label: 'Caret up', value: 'fa fa-caret-up' },
{ label: 'Caret in square down', value: 'fa fa-caret-square-o-down' },
{ label: 'Caret in square left', value: 'fa fa-caret-square-o-left' },
{ label: 'Caret in square right', value: 'fa fa-caret-square-o-right' },
{ label: 'Caret in square up', value: 'fa fa-caret-square-o-up' },
{ label: 'Closed captioning', value: 'fa fa-cc' },
{ label: 'Certificate starburst', value: 'fa fa-certificate' },
{ label: 'Chart bar', value: 'fa fa-bar-chart' },
{ label: 'Chart line', value: 'fa fa-line-chart' },
{ label: 'Checkerboard', value: 'fa fa-delicious' },
{ label: 'Checkmark', value: 'fa fa-check' },
{ label: 'Checkmark in circle', value: 'fa fa-check-circle' },
{ label: 'Checkmark in circle outline', value: 'fa fa-check-circle-o' },
{ label: 'Checkmark in square', value: 'fa fa-check-square' },
{ label: 'Checkmark in square outline', value: 'fa fa-check-square-o' },
{ label: 'Chevron in circle down', value: 'fa fa-chevron-circle-down' },
{ label: 'Chevron in circle left', value: 'fa fa-chevron-circle-left' },
{ label: 'Chevron in circle right', value: 'fa fa-chevron-circle-right' },
{ label: 'Chevron in circle up', value: 'fa fa-chevron-circle-up' },
{ label: 'Chevron down', value: 'fa fa-chevron-down' },
{ label: 'Chevron left', value: 'fa fa-chevron-left' },
{ label: 'Chevron right', value: 'fa fa-chevron-right' },
{ label: 'Chevron up', value: 'fa fa-chevron-up' },
{ label: 'Child', value: 'fa fa-child' },
{ label: 'Chinese character pointing to A', value: 'fa fa-language' },
{ label: 'Chrome logo', value: 'fa fa-chrome' },
{ label: 'Circle', value: 'fa fa-circle' },
{ label: 'Circle outline', value: 'fa fa-circle-o' },
{ label: 'Circle outline with notch', value: 'fa fa-circle-o-notch' },
{ label: 'Thin circle outline', value: 'fa fa-circle-thin' },
{ label: 'Clipboard', value: 'fa fa-clipboard' },
{ label: 'Clock outline', value: 'fa fa-clock-o' },
{ label: 'Clone two squares', value: 'fa fa-clone' },
{ label: 'Cloud', value: 'fa fa-cloud' },
{ label: 'Cloud download', value: 'fa fa-cloud-download' },
{ label: 'Cloud upload', value: 'fa fa-cloud-upload' },
{ label: 'Code tags', value: 'fa fa-code' },
{ label: 'Code fork', value: 'fa fa-code-fork' },
{ label: 'Coffee', value: 'fa fa-coffee' },
{ label: 'Cog', value: 'fa fa-cog' },
{ label: 'Cogs', value: 'fa fa-cogs' },
{ label: 'Columns', value: 'fa fa-columns' },
{ label: 'Comment bubble', value: 'fa fa-comment' },
{ label: 'Comment bubble with ellipsis', value: 'fa fa-commenting' },
{ label: 'Two comment bubbles', value: 'fa fa-comments' },
{ label: 'Comment bubble outline', value: 'fa fa-comment-o' },
{ label: 'Comment bubble outline with ellipsis', value: 'fa fa-commenting-o' },
{ label: 'Two comment bubble outlines', value: 'fa fa-comments-o' },
{ label: 'Compass', value: 'fa fa-compass' },
{ label: 'Compress', value: 'fa fa-compress' },
{ label: 'Copyright', value: 'fa fa-copyright' },
{ label: 'Creative Commons', value: 'fa fa-creative-commons' },
{ label: 'Crop', value: 'fa fa-crop' },
{ label: 'Crosshairs', value: 'fa fa-crosshairs' },
{ label: 'Cube', value: 'fa fa-cube' },
{ label: 'Three Cubes', value: 'fa fa-cubes' },
{ label: 'Cutlery', value: 'fa fa-cutlery' },
{ label: 'Database discs', value: 'fa fa-database' },
{ label: 'Deaf', value: 'fa fa-deaf' },
{ label: 'Desktop Computer', value: 'fa fa-desktop' },
{ label: 'Diamond', value: 'fa fa-diamond' },
{ label: 'Download with down arrow', value: 'fa fa-download' },
{ label: 'Upload with up arrow', value: 'fa fa-upload' },
{ label: 'Microsoft Edge', value: 'fa fa-edge' },
{ label: 'Eject icon', value: 'fa fa-eject' },
{ label: 'Ellipsis horizontal', value: 'fa fa-ellipsis-h' },
{ label: 'Ellipsis vertical', value: 'fa fa-ellipsis-v' },
{ label: 'Envelope', value: 'fa fa-envelope' },
{ label: 'Envelope open', value: 'fa fa-envelope-open' },
{ label: 'Envelope outline', value: 'fa fa-envelope-o' },
{ label: 'Envelope open outline', value: 'fa fa-envelope-open-o' },
{ label: 'Envelope in square', value: 'fa fa-envelope-square' },
{ label: 'Eraser', value: 'fa fa-eraser' },
{ label: 'Exclamation', value: 'fa fa-exclamation' },
{ label: 'Exclamation in circle', value: 'fa fa-exclamation-circle' },
{ label: 'Exclamation in triangle', value: 'fa fa-exclamation-triangle' },
{ label: 'Eye', value: 'fa fa-eye' },
{ label: 'Eye slashed out', value: 'fa fa-eye-slash' },
{ label: 'Eyedropper', value: 'fa fa-eyedropper' },
{ label: 'Facebook', value: 'fa fa-facebook' },
{ label: 'Facebook in official square', value: 'fa fa-facebook-official' },
{ label: 'Facebook in rounded square', value: 'fa fa-facebook-square' },
{ label: 'Factory', value: 'fa fa-industry' },
{ label: 'Fax machine', value: 'fa fa-fax' },
{ label: 'Fighter jet', value: 'fa fa-fighter-jet' },
{ label: 'File shaded page', value: 'fa fa-file' },
{ label: 'File text shaded', value: 'fa fa-file-text' },
{ label: 'File archive outline', value: 'fa fa-file-archive-o' },
{ label: 'File audio outline', value: 'fa fa-file-audio-o' },
{ label: 'File code outline', value: 'fa fa-file-code-o' },
{ label: 'File Excel outline', value: 'fa fa-file-excel-o' },
{ label: 'File image outline', value: 'fa fa-file-image-o' },
{ label: 'File outline page', value: 'fa fa-file-o' },
{ label: 'Files two outline pages', value: 'fa fa-files-o' },
{ label: 'File PDF outline', value: 'fa fa-file-pdf-o' },
{ label: 'File PowerPoint outline', value: 'fa fa-file-powerpoint-o' },
{ label: 'File text outline', value: 'fa fa-file-text-o' },
{ label: 'File video outline', value: 'fa fa-file-video-o' },
{ label: 'File Word outline', value: 'fa fa-file-word-o' },
{ label: 'Film', value: 'fa fa-film' },
{ label: 'Filter funnel', value: 'fa fa-filter' },
{ label: 'Fire flame', value: 'fa fa-fire' },
{ label: 'Fire extinguisher', value: 'fa fa-fire-extinguisher' },
{ label: 'Firefox', value: 'fa fa-firefox' },
{ label: 'Flag', value: 'fa fa-flag' },
{ label: 'Flag checkered', value: 'fa fa-flag-checkered' },
{ label: 'Flag outline', value: 'fa fa-flag-o' },
{ label: 'Flask', value: 'fa fa-flask' },
{ label: 'Flickr', value: 'fa fa-flickr' },
{ label: 'Floppy disk outline', value: 'fa fa-floppy-o' },
{ label: 'Folder', value: 'fa fa-folder' },
{ label: 'Folder open', value: 'fa fa-folder-open' },
{ label: 'Folder outline', value: 'fa fa-folder-o' },
{ label: 'Folder open outline', value: 'fa fa-folder-open-o' },
{ label: 'Font A', value: 'fa fa-font' },
{ label: 'Fort', value: 'fa fa-fort-awesome' },
{ label: 'Foursquare', value: 'fa fa-foursquare' },
{ label: 'Game controller', value: 'fa fa-gamepad' },
{ label: 'Gavel', value: 'fa fa-gavel' },
{ label: 'Genderless', value: 'fa fa-genderless' },
{ label: 'Gender female', value: 'fa fa-female' },
{ label: 'Gender male', value: 'fa fa-male' },
{ label: 'Gender Mars', value: 'fa fa-mars' },
{ label: 'Gender two Mars', value: 'fa fa-mars-double' },
{ label: 'Gender Mars with stroke', value: 'fa fa-mars-stroke' },
{ label: 'Gender Mars with stroke horizontal', value: 'fa fa-mars-stroke-h' },
{ label: 'Gender Mars with stroke vertical', value: 'fa fa-mars-stroke-v' },
{ label: 'Gender Mercury', value: 'fa fa-mercury' },
{ label: 'Gender neuter', value: 'fa fa-neuter' },
{ label: 'Gender Transgender with 2 genders', value: 'fa fa-transgender' },
{ label: 'Gender Transgender with 3 genders', value: 'fa fa-transgender-alt' },
{ label: 'Gender Venus', value: 'fa fa-venus' },
{ label: 'Gender two Venus', value: 'fa fa-venus-double' },
{ label: 'Gender Venus and Mars', value: 'fa fa-venus-mars' },
{ label: 'Geolocation arrow', value: 'fa fa-location-arrow' },
{ label: 'Gift', value: 'fa fa-gift' },
{ label: 'Github', value: 'fa fa-github' },
{ label: 'Git', value: 'fa fa-github-alt' },
{ label: 'Globe', value: 'fa fa-globe' },
{ label: 'Google', value: 'fa fa-google' },
{ label: 'Graduation cap', value: 'fa fa-graduation-cap' },
{ label: 'Hospital H in square', value: 'fa fa-h-square' },
{ label: 'Hand rock outline', value: 'fa fa-hand-rock-o' },
{ label: 'Hand paper outline', value: 'fa fa-hand-paper-o' },
{ label: 'Hand scissors outline', value: 'fa fa-hand-scissors-o' },
{ label: 'Hand lizard outline', value: 'fa fa-hand-lizard-o' },
{ label: 'Hand Spock outline', value: 'fa fa-hand-spock-o' },
{ label: 'Hand down outline', value: 'fa fa-hand-o-down' },
{ label: 'Hand left outline', value: 'fa fa-hand-o-left' },
{ label: 'Hand right outline', value: 'fa fa-hand-o-right' },
{ label: 'Hand up outline', value: 'fa fa-hand-o-up' },
{ label: 'Hand peace outline', value: 'fa fa-hand-peace-o' },
{ label: 'Hand pointer outline', value: 'fa fa-hand-pointer-o' },
{ label: 'Handshake outline', value: 'fa fa-handshake-o' },
{ label: 'Hard disk drive', value: 'fa fa-hdd-o' },
{ label: 'Hashtag', value: 'fa fa-hashtag' },
{ label: 'Header H', value: 'fa fa-header' },
{ label: 'Headphones', value: 'fa fa-headphones' },
{ label: 'Heart', value: 'fa fa-heart' },
{ label: 'Heart outline', value: 'fa fa-heart-o' },
{ label: 'Heartbeat', value: 'fa fa-heartbeat' },
{ label: 'History counterclockwise arrow', value: 'fa fa-history' },
{ label: 'House', value: 'fa fa-home' },
{ label: 'Honey dipper', value: 'fa fa-forumbee' },
{ label: 'Hospital outline', value: 'fa fa-hospital-o' },
{ label: 'Hourglass', value: 'fa fa-hourglass' },
{ label: 'Hourglass start', value: 'fa fa-hourglass-start' },
{ label: 'Hourglass half full', value: 'fa fa-hourglass-half' },
{ label: 'Hourglass end', value: 'fa fa-hourglass-end' },
{ label: 'Hourglass outline', value: 'fa fa-hourglass-o' },
{ label: 'ID badge', value: 'fa fa-id-badge' },
{ label: 'ID card', value: 'fa fa-id-card' },
{ label: 'ID card outline', value: 'fa fa-id-card-o' },
{ label: 'Inbox', value: 'fa fa-inbox' },
{ label: 'Info lowercase i', value: 'fa fa-info' },
{ label: 'Info lowercase i in a circle', value: 'fa fa-info-circle' },
{ label: 'Instagram logo', value: 'fa fa-instagram' },
{ label: 'Key', value: 'fa fa-key' },
{ label: 'Keyboard outline', value: 'fa fa-keyboard-o' },
{ label: 'Laptop', value: 'fa fa-laptop' },
{ label: 'Leaf', value: 'fa fa-leaf' },
{ label: 'Lemon outline', value: 'fa fa-lemon-o' },
{ label: 'Level down arrow', value: 'fa fa-level-down' },
{ label: 'Level up arrow', value: 'fa fa-level-up' },
{ label: 'Life preserver', value: 'fa fa-life-ring' },
{ label: 'Light bulb outline', value: 'fa fa-lightbulb-o' },
{ label: 'Link', value: 'fa fa-link' },
{ label: 'Link broken', value: 'fa fa-chain-broken' },
{ label: 'Link arrow in outline', value: 'fa fa-external-link' },
{ label: 'Link arrow in square', value: 'fa fa-external-link-square' },
{ label: 'LinkedIn logo', value: 'fa fa-linkedin' },
{ label: 'LinkedIn logo in square', value: 'fa fa-linkedin-square' },
{ label: 'List', value: 'fa fa-list' },
{ label: 'List with heading', value: 'fa fa-list-alt' },
{ label: 'List with numbers', value: 'fa fa-list-ol' },
{ label: 'List with bullets', value: 'fa fa-list-ul' },
{ label: 'Lock', value: 'fa fa-lock' },
{ label: 'Lock in circle', value: 'fa fa-expeditedssl' },
{ label: 'Unlocked lock', value: 'fa fa-unlock' },
{ label: 'Unlocked compact lock', value: 'fa fa-unlock-alt' },
{ label: 'Low vision', value: 'fa fa-low-vision' },
{ label: 'Magic wand', value: 'fa fa-magic' },
{ label: 'Magnet', value: 'fa fa-magnet' },
{ label: 'Map', value: 'fa fa-map' },
{ label: 'Map marker', value: 'fa fa-map-marker' },
{ label: 'Map outline', value: 'fa fa-map-o' },
{ label: 'Map pin', value: 'fa fa-map-pin' },
{ label: 'Map signs', value: 'fa fa-map-signs' },
{ label: 'Martini glass', value: 'fa fa-glass' },
{ label: 'Medical kit', value: 'fa fa-medkit' },
{ label: 'Smiley face', value: 'fa fa-smile-o' },
{ label: 'Smiley frowning', value: 'fa fa-frown-o' },
{ label: 'Smiley meh', value: 'fa fa-meh-o' },
{ label: 'Microchip', value: 'fa fa-microchip' },
{ label: 'Microphone', value: 'fa fa-microphone' },
{ label: 'Microphone slashed out', value: 'fa fa-microphone-slash' },
{ label: 'Minus', value: 'fa fa-minus' },
{ label: 'Minus in circle', value: 'fa fa-minus-circle' },
{ label: 'Minus in square', value: 'fa fa-minus-square' },
{ label: 'Minus in square outline', value: 'fa fa-minus-square-o' },
{ label: 'Mobile phone', value: 'fa fa-mobile' },
{ label: 'Money', value: 'fa fa-money' },
{ label: 'Credit Card', value: 'fa fa-credit-card-alt' },
{ label: 'Credit Card outline', value: 'fa fa-credit-card' },
{ label: 'American Express logo', value: 'fa fa-cc-amex' },
{ label: 'Diners Club logo', value: 'fa fa-cc-diners-club' },
{ label: 'Discover card logo', value: 'fa fa-cc-discover' },
{ label: 'JCB card logo', value: 'fa fa-cc-jcb' },
{ label: 'MasterCard logo', value: 'fa fa-cc-mastercard' },
{ label: 'PayPal logo', value: 'fa fa-cc-paypal' },
{ label: 'Stripe logo', value: 'fa fa-cc-stripe' },
{ label: 'Visa card logo', value: 'fa fa-cc-visa' },
{ label: 'Bitcoin currency', value: 'fa fa-btc' },
{ label: 'Euro currency', value: 'fa fa-eur' },
{ label: 'Great Britain Pound currency', value: 'fa fa-gbp' },
{ label: 'GG currency', value: 'fa fa-gg' },
{ label: 'GG currency in a circle', value: 'fa fa-gg-circle' },
{ label: 'Israeli New Shekel currency', value: 'fa fa-ils' },
{ label: 'Indian Rupee currency', value: 'fa fa-inr' },
{ label: 'Japanese Yen currency', value: 'fa fa-jpy' },
{ label: 'South Korean Won currency', value: 'fa fa-krw' },
{ label: 'Russian Ruble currency', value: 'fa fa-rub' },
{ label: 'Turkish Lira currency', value: 'fa fa-try' },
{ label: 'US Dollar currency', value: 'fa fa-usd' },
{ label: 'Viacoin currency', value: 'fa fa-viacoin' },
{ label: 'Crescent moon outline', value: 'fa fa-moon-o' },
{ label: 'Motorcycle', value: 'fa fa-motorcycle' },
{ label: 'Mouse pointer', value: 'fa fa-mouse-pointer' },
{ label: 'Music notes', value: 'fa fa-music' },
{ label: 'Newspaper outline', value: 'fa fa-newspaper-o' },
{ label: 'Object group', value: 'fa fa-object-group' },
{ label: 'Object ungroup', value: 'fa fa-object-ungroup' },
{ label: 'Paintbrush', value: 'fa fa-paint-brush' },
{ label: 'Paper plane', value: 'fa fa-paper-plane' },
{ label: 'Paper plane in circle', value: 'fa fa-telegram' },
{ label: 'Paper plane outline', value: 'fa fa-paper-plane-o' },
{ label: 'Paperclip', value: 'fa fa-paperclip' },
{ label: 'Paw', value: 'fa fa-paw' },
{ label: 'Pencil', value: 'fa fa-pencil' },
{ label: 'Pencil in square', value: 'fa fa-pencil-square' },
{ label: 'Pencil in square outline', value: 'fa fa-pencil-square-o' },
{ label: 'Percent', value: 'fa fa-percent' },
{ label: 'Phone', value: 'fa fa-phone' },
{ label: 'Phone in square', value: 'fa fa-phone-square' },
{ label: 'Phone with volume control', value: 'fa fa-volume-control-phone' },
{ label: 'Picture', value: 'fa fa-picture-o' },
{ label: 'Pie chart', value: 'fa fa-pie-chart' },
{ label: 'Pied Piper hat logo', value: 'fa fa-pied-piper' },
{ label: 'Pied Piper silhouette logo', value: 'fa fa-pied-piper-alt' },
{ label: 'Pinterest logo', value: 'fa fa-pinterest-p' },
{ label: 'Pinterest logo in circle', value: 'fa fa-pinterest' },
{ label: 'Pinterest logo in square', value: 'fa fa-pinterest-square' },
{ label: 'Plane', value: 'fa fa-plane' },
{ label: 'Plug', value: 'fa fa-plug' },
{ label: 'Podcast', value: 'fa fa-podcast' },
{ label: 'Power off', value: 'fa fa-power-off' },
{ label: 'Printer', value: 'fa fa-print' },
{ label: 'Puzzle piece', value: 'fa fa-puzzle-piece' },
{ label: 'QR code', value: 'fa fa-qrcode' },
{ label: 'Question mark', value: 'fa fa-question' },
{ label: 'Question mark in circle', value: 'fa fa-question-circle' },
{ label: 'Question mark in circle outline', value: 'fa fa-question-circle-o' },
{ label: 'Opening double quotation mark', value: 'fa fa-quote-left' },
{ label: 'Closing double quotation mark', value: 'fa fa-quote-right' },
{ label: 'Recycle', value: 'fa fa-recycle' },
{ label: 'Refresh arrows', value: 'fa fa-refresh' },
{ label: 'Registered trademark', value: 'fa fa-registered' },
{ label: 'Road', value: 'fa fa-road' },
{ label: 'Rocketship', value: 'fa fa-rocket' },
{ label: 'RSS', value: 'fa fa-rss' },
{ label: 'RSS in square', value: 'fa fa-rss-square' },
{ label: 'Scale', value: 'fa fa-balance-scale' },
{ label: 'Scissors', value: 'fa fa-scissors' },
{ label: 'Search magnifying glass', value: 'fa fa-search' },
{ label: 'Search magnifying glass with minus', value: 'fa fa-search-minus' },
{ label: 'Search magnifying glass with plus', value: 'fa fa-search-plus' },
{ label: 'Server stacks', value: 'fa fa-server' },
{ label: 'Share branches', value: 'fa fa-share-alt' },
{ label: 'Share branches in square', value: 'fa fa-share-alt-square' },
{ label: 'Shield', value: 'fa fa-shield' },
{ label: 'Ship', value: 'fa fa-ship' },
{ label: 'Shopping bag', value: 'fa fa-shopping-bag' },
{ label: 'Shopping basket', value: 'fa fa-shopping-basket' },
{ label: 'Shopping cart', value: 'fa fa-shopping-cart' },
{ label: 'Shopping cart with down arrow', value: 'fa fa-cart-arrow-down' },
{ label: 'Shopping cart with plus', value: 'fa fa-cart-plus' },
{ label: 'Shower', value: 'fa fa-shower' },
{ label: 'Sign language', value: 'fa fa-sign-language' },
{ label: 'Signal bars', value: 'fa fa-signal' },
{ label: 'Sitemap', value: 'fa fa-sitemap' },
{ label: 'Skype logo', value: 'fa fa-skype' },
{ label: 'Slack logo', value: 'fa fa-slack' },
{ label: 'Sliders', value: 'fa fa-sliders' },
{ label: 'Slideshare logo', value: 'fa fa-slideshare' },
{ label: 'Snapchat logo', value: 'fa fa-snapchat' },
{ label: 'Snapchat ghost logo', value: 'fa fa-snapchat-ghost' },
{ label: 'Snapchat logo in square', value: 'fa fa-snapchat-square' },
{ label: 'Snowflake', value: 'fa fa-snowflake-o' },
{ label: 'Soccer ball', value: 'fa fa-futbol-o' },
{ label: 'Space shuttle', value: 'fa fa-space-shuttle' },
{ label: 'Spinner', value: 'fa fa-spinner' },
{ label: 'Spoon', value: 'fa fa-spoon' },
{ label: 'Spotify logo', value: 'fa fa-spotify' },
{ label: 'Square with rounded corners', value: 'fa fa-square' },
{ label: 'Square with rounded corners outline', value: 'fa fa-square-o' },
{ label: 'Star', value: 'fa fa-star' },
{ label: 'Half star', value: 'fa fa-star-half' },
{ label: 'Star outline', value: 'fa fa-star-o' },
{ label: 'Half star outline', value: 'fa fa-star-half-o' },
{ label: 'Stethoscope', value: 'fa fa-stethoscope' },
{ label: 'Sticky note', value: 'fa fa-sticky-note' },
{ label: 'Sticky note outline', value: 'fa fa-sticky-note-o' },
{ label: 'Street view person', value: 'fa fa-street-view' },
{ label: 'Strikethrough', value: 'fa fa-strikethrough' },
{ label: 'Subway', value: 'fa fa-subway' },
{ label: 'Suitcase', value: 'fa fa-suitcase' },
{ label: 'Sun outline', value: 'fa fa-sun-o' },
{ label: 'Table', value: 'fa fa-table' },
{ label: 'Tablet', value: 'fa fa-tablet' },
{ label: 'Tachometer', value: 'fa fa-tachometer' },
{ label: 'Tag', value: 'fa fa-tag' },
{ label: 'Tags', value: 'fa fa-tags' },
{ label: 'Target', value: 'fa fa-dot-circle-o' },
{ label: 'Task list progress bars', value: 'fa fa-tasks' },
{ label: 'Taxi', value: 'fa fa-taxi' },
{ label: 'Television', value: 'fa fa-television' },
{ label: 'Terminal cursor', value: 'fa fa-terminal' },
{ label: 'Text cursor', value: 'fa fa-i-cursor', ariaLabel: 'Text cursor' },
{ label: 'Text paragraph', value: 'fa fa-paragraph' },
{ label: 'Text indent', value: 'fa fa-indent' },
{ label: 'Text italic', value: 'fa fa-italic' },
{ label: 'Text height', value: 'fa fa-text-height' },
{ label: 'Text width', value: 'fa fa-text-width' },
{ label: 'Text subscript', value: 'fa fa-subscript' },
{ label: 'Text superscript', value: 'fa fa-superscript' },
{ label: 'Text underline', value: 'fa fa-underline' },
{ label: 'Table heading', value: 'fa fa-th' },
{ label: 'Table heading large', value: 'fa fa-th-large' },
{ label: 'Table heading list', value: 'fa fa-th-list' },
{ label: 'Thermometer empty', value: 'fa fa-thermometer-empty' },
{ label: 'Thermometer one-quarter full', value: 'fa fa-thermometer-quarter' },
{ label: 'Thermometer half full', value: 'fa fa-thermometer-half' },
{ label: 'Thermometer three-quarters full', value: 'fa fa-thermometer-three-quarters' },
{ label: 'Thermometer full', value: 'fa fa-thermometer-full' },
{ label: 'Three horizontal lines', value: 'fa fa-bars' },
{ label: 'Thumbtack', value: 'fa fa-thumb-tack' },
{ label: 'Thumb down', value: 'fa fa-thumbs-down' },
{ label: 'Thumb up', value: 'fa fa-thumbs-up' },
{ label: 'Thumb down outline', value: 'fa fa-thumbs-o-down' },
{ label: 'Thumb up outline', value: 'fa fa-thumbs-o-up' },
{ label: 'Ticket stub', value: 'fa fa-ticket' },
{ label: 'Times x', value: 'fa fa-times' },
{ label: 'Times x in circle', value: 'fa fa-times-circle' },
{ label: 'Times x in circle outline', value: 'fa fa-times-circle-o' },
{ label: 'Tint droplet', value: 'fa fa-tint' },
{ label: 'Toggle off', value: 'fa fa-toggle-off' },
{ label: 'Toggle on', value: 'fa fa-toggle-on' },
{ label: 'Trademark', value: 'fa fa-trademark' },
{ label: 'Train', value: 'fa fa-train' },
{ label: 'Trash can', value: 'fa fa-trash' },
{ label: 'Trash can outline', value: 'fa fa-trash-o' },
{ label: 'Tree', value: 'fa fa-tree' },
{ label: 'Trophy', value: 'fa fa-trophy' },
{ label: 'Truck', value: 'fa fa-truck' },
{ label: 'TTY telephone', value: 'fa fa-tty' },
{ label: 'Twitter logo', value: 'fa fa-twitter' },
{ label: 'Twitter logo in square', value: 'fa fa-twitter-square' },
{ label: 'Umbrella', value: 'fa fa-umbrella' },
{ label: 'Universal Access', value: 'fa fa-universal-access' },
{ label: 'University', value: 'fa fa-university' },
{ label: 'USB logo', value: 'fa fa-usb' },
{ label: 'User silhouette', value: 'fa fa-user' },
{ label: 'User silhouette in circle', value: 'fa fa-user-circle' },
{ label: 'User silhouette in circle outline', value: 'fa fa-user-circle-o' },
{ label: 'User with stethoscope', value: 'fa fa-user-md' },
{ label: 'User silhouette outline', value: 'fa fa-user-o' },
{ label: 'User silhouette with plus', value: 'fa fa-user-plus' },
{ label: 'User silhouette with hat and trenchcoat', value: 'fa fa-user-secret' },
{ label: 'User silhouette with X', value: 'fa fa-user-times' },
{ label: 'Three user silhouettes', value: 'fa fa-users' },
{ label: 'Video camera', value: 'fa fa-video-camera' },
{ label: 'Video pause', value: 'fa fa-pause' },
{ label: 'Video pause in circle', value: 'fa fa-pause-circle' },
{ label: 'Video pause in circle outline', value: 'fa fa-pause-circle-o' },
{ label: 'Video play', value: 'fa fa-play' },
{ label: 'Video play in circle', value: 'fa fa-play-circle' },
{ label: 'Video play in circle outline', value: 'fa fa-play-circle-o' },
{ label: 'Video rewind', value: 'fa fa-backward' },
{ label: 'Video fast forward', value: 'fa fa-forward' },
{ label: 'Video previous chapter', value: 'fa fa-fast-backward' },
{ label: 'Video next chapter', value: 'fa fa-fast-forward' },
{ label: 'Video repeat', value: 'fa fa-repeat' },
{ label: 'Video step backward', value: 'fa fa-step-backward' },
{ label: 'Video step forward arrow', value: 'fa fa-step-forward' },
{ label: 'Video stop', value: 'fa fa-stop' },
{ label: 'Video stop in circle', value: 'fa fa-stop-circle' },
{ label: 'Video stop in circle outline', value: 'fa fa-stop-circle-o' },
{ label: 'Vimeo logo', value: 'fa fa-vimeo' },
{ label: 'Vimeo logo in square', value: 'fa fa-vimeo-square' },
{ label: 'Volume down', value: 'fa fa-volume-down' },
{ label: 'Volume off', value: 'fa fa-volume-off' },
{ label: 'Volume up', value: 'fa fa-volume-up' },
{ label: 'Whatsapp logo', value: 'fa fa-whatsapp' },
{ label: 'Wheelchair', value: 'fa fa-wheelchair' },
{ label: 'Wheelchair with user going quickly', value: 'fa fa-wheelchair-alt' },
{ label: 'Wifi', value: 'fa fa-wifi' },
{ label: 'Wikipedia logo', value: 'fa fa-wikipedia-w' },
{ label: 'Window close', value: 'fa fa-window-close' },
{ label: 'Window close outline', value: 'fa fa-window-close-o' },
{ label: 'Window maximize', value: 'fa fa-window-maximize' },
{ label: 'Window minimize', value: 'fa fa-window-minimize' },
{ label: 'Window restore', value: 'fa fa-window-restore' },
{ label: 'Windows logo', value: 'fa fa-windows' },
{ label: 'WordPress logo', value: 'fa fa-wordpress' },
{ label: 'Wrench', value: 'fa fa-wrench' },
{ label: 'Yelp logo', value: 'fa fa-yelp' },
{ label: 'YouTube logo', value: 'fa fa-youtube' },
{ label: 'YouTube play button', value: 'fa fa-youtube-play' },
{ label: 'YouTube logo in square', value: 'fa fa-youtube-square' },
];
export default dropdownOptions;