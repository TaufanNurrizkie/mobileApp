document.addEventListener('DOMContentLoaded', () => {
    const chatInput = document.querySelector('.chat-input');
    const sendIcon = document.querySelector('.send-icon');

    sendIcon.addEventListener('click', () => {
        const message = chatInput.value.trim();
        if (message) {
            addChatBubble(message, 'sent');
            chatInput.value = '';
            autoReply(message);
        }
    });

    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            const message = chatInput.value.trim();
            if (message) {
                addChatBubble(message, 'sent');
                chatInput.value = '';
                autoReply(message);
            }
        }
    });

    function addChatBubble(message, type) {
        const chatContainer = document.querySelector('.chat-container');
        const chatBubble = document.createElement('div');
        chatBubble.classList.add('chat-bubble', type);
        chatBubble.innerHTML = `<p>${message}</p><span class="timestamp">${new Date().toLocaleTimeString()}</span>`;
        chatContainer.appendChild(chatBubble);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function autoReply(message) {
        const defaultReplies = [
            "I'm not sure how to respond to that.",
            "Can you please elaborate?",
            "Interesting! Tell me more.",
            "I'm here to chat!",
            "That's cool!",
            "Really? Tell me more.",
            "I'm not sure what you mean."
        ];

        const replyMessage = generateDynamicReply(message) || defaultReplies[Math.floor(Math.random() * defaultReplies.length)];

        setTimeout(() => {
            addChatBubble(replyMessage, 'received');
        }, 1000);
    }

    function generateDynamicReply(message) {
        const lowerCaseMessage = message.toLowerCase();
        if (lowerCaseMessage.includes('hello') || lowerCaseMessage.includes('hi')) {
            return "Hello! How can I help you today?";
        }
        if (lowerCaseMessage.includes('how are you')) {
            return "I'm doing well, thanks for asking! How about you?";
        }
        if (lowerCaseMessage.includes('bye')) {
            return "Goodbye! Have a great day!";
        }
        if (lowerCaseMessage.includes('thanks') || lowerCaseMessage.includes('thank you')) {
            return "You're welcome!";
        }
        // Add more conditions as needed

        // Return null if no specific reply is found
        return null;
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
    const backButton = document.getElementById('backButton');
    
    backButton.addEventListener('click', () => {
        window.location.href = 'index.php';
    });
});
