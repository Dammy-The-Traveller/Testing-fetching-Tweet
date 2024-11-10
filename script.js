
window.addEventListener('load', function () {
    fetchTweets(); 


})
async function fetchTweets() {
    try {
        const response = await fetch('twitterProxy.php'); 
        const data = await response.json();

        if (data && data.data) {
            const tweets = data.data;
            const media = data.includes?.media || [];

            tweets.forEach(tweet => {
                const tweetDiv = document.createElement('div');
                tweetDiv.classList.add('tweet');

                // Add tweet text
                const tweetText = document.createElement('p');
                tweetText.textContent = tweet.text;
                tweetDiv.appendChild(tweetText);

                // Check for attachments and media
                if (tweet.attachments && tweet.attachments.media_keys) {
                    tweet.attachments.media_keys.forEach(key => {
                        const mediaItem = media.find(m => m.media_key === key);
                        if (mediaItem && mediaItem.type === 'photo') {
                            const img = document.createElement('img');
                            img.src = mediaItem.url;
                            img.alt = "Tweet image";
                            img.style.width = "100%"; // Adjust as needed
                            tweetDiv.appendChild(img);
                        }
                    });
                }

                // Append the tweet to the container
                document.getElementById('tweets-container').appendChild(tweetDiv);
            });
        } else {
            console.log("No tweets found!");
        }
    } catch (error) {
        console.error('Error fetching tweets:', error);
    }
}






