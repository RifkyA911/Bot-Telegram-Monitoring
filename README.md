
# Bot-Telegram-Monitoring

## Overview
Rekeningku_DW Bot is a Telegram bot designed to provide cryptocurrency market information and perform various actions. It leverages the Rekeningku (Reku.com) API to fetch real-time market data and offers functionalities such as displaying asset information, identifying market highs and lows, and more. 


## Installation
Make sure you `git clone` first this repository in your file manager cpanel hosting. then do the steps below:
1. Make new your bot channel from botfather. And do get your `BOT_TOKEN` on botfather telegram. For more detail https://telegram.me/BotFather
2. Define the `BOT_TOKEN` with your Telegram Bot token in the `CURL_API_Rekeningku.php` file.
3. Ensure that PHP is installed on your server.
4. Run the command
    
## Appendix

Any additional information goes here


## Conslusion

- This bot was created as part of a university assignment.
- For specific command usage and more details, refer to the individual command sections above.
Feel free to reach out for any questions or improvements!

## Command Reference

| Command|  Description                       |
| :-------- |  :-------------------------------- |
| `/start`      | Displays a welcome message and provides instructions on how to use the bot. |
| `/info`      |  Display and fetches and displays information about various cryptocurrency assets. Shows details like Close Price, High, Low, Open, Volume, Change Percentage, and Market Cap. |
| `/pull`      |Displays assets with the highest and lowest market prices |
| `/range`      | Displays range, top, and lower values with percentages for each asset|
| `/about`      | Displays information about the Rekeningku_DW bot and its purpose|
| `/live`      |Initiates live data display of high and low market prices. Updates every 30 seconds |



## Lessons Learned

What did you learn while building this project? What challenges did you face and how did you overcome them?

