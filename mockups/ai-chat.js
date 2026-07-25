/**
 * Villa Esmeralda — Shared AI Chat Module (Transformers.js)
 * Powers realistic AI chat on both landing page and manager panel.
 * Uses Hugging Face Transformers.js with a small instruction-tuned model.
 */
const AI_CHAT = (() => {
  let pipeline = null;
  let isLoading = false;
  let chatHistory = [];
  
  // Villa context for the AI assistant
  const VILLA_CONTEXT = `You are the AI concierge for Villa Esmeralda, a luxury holiday villa in Costa Calma, Fuerteventura, Canary Islands, Spain.
  
  ABOUT THE VILLA:
  - Located at Calle la Dorada 12, Costa Calma, 35627, Fuerteventura
  - 300m from the white sandy beach of Costa Calma
  - 3 rooms: Master Suite (€180/night, king bed, ocean view, en-suite bathroom), Junior Suite (€130/night, queen bed, terrace, shower), Entire Villa (€380/night, 3 bedrooms, private pool, up to 6 people)
  - Private infinity pool with ocean view
  - Free high-speed WiFi, private parking
  - AI-powered concierge service 24/7
  - Secure payment via credit card or SEPA (Stripe integration)
  
  AMENITIES:
  - Check-in: from 3:00 PM, Check-out: by 11:00 AM
  - Early check-in available upon request
  - Child-friendly
  - Languages: German, English, Spanish
  
  LOCAL AREA:
  - Costa Calma beach: white sand, turquoise water, 300m away
  - Corralejo Natural Park and sand dunes: 45 min drive
  - Local restaurants within walking distance (La Jaula de Oro, 5 min walk)
  - Water sports, hiking, cycling routes nearby
  
  BEHAVIOR:
  - Be helpful, friendly, and concise
  - Answer in the same language the guest uses
  - If asked about prices, availability, or booking details, provide accurate information and suggest checking the booking section
  - If asked something you don't know, be honest and suggest contacting the villa directly
  - Keep responses under 3 sentences`;

  async function initPipeline() {
    if (pipeline) return pipeline;
    if (isLoading) {
      // Wait for existing load
      while (isLoading) await new Promise(r => setTimeout(r, 100));
      return pipeline;
    }
    isLoading = true;
    try {
      const { pipeline: pipe } = await import('https://cdn.jsdelivr.net/npm/@xenova/transformers@2.17.2');
      pipeline = await pipe('text-generation', 'onnx-community/Qwen2.5-0.5B-Instruct', {
        quantized: true,
        progress_callback: (info) => {
          // Progress reporting handled silently
        }
      });
      console.log('[AI Chat] Model loaded successfully');
    } catch (e) {
      console.warn('[AI Chat] Failed to load model, falling back to rule-based', e.message);
      pipeline = null;
    }
    isLoading = false;
    return pipeline;
  }

  async function askAI(userMessage, language = 'en') {
    // Fallback to rule-based if model not available
    if (!pipeline) {
      return getFallbackResponse(userMessage, language);
    }

    try {
      const systemPrompt = VILLA_CONTEXT + '\n\n' +
        (language === 'de' 
          ? 'Sprich auf Deutsch. Sei kurz und hilfreich.'
          : 'Speak in English. Be brief and helpful.');

      const messages = [
        { role: 'system', content: systemPrompt },
        ...chatHistory.slice(-4),
        { role: 'user', content: userMessage }
      ];

      const prompt = messages.map(m => 
        `<|im_start|>${m.role}\n${m.content}<|im_end|>`
      ).join('\n') + '\n<|im_start|>assistant\n';

      const result = await pipeline(prompt, {
        max_new_tokens: 100,
        temperature: 0.7,
        do_sample: true,
        top_p: 0.9,
      });

      const response = result[0].generated_text;
      // Extract only the assistant's response
      const assistantPart = response.split('<|im_start|>assistant\n').pop().split('<|im_end|>')[0].trim();
      
      chatHistory.push(
        { role: 'user', content: userMessage },
        { role: 'assistant', content: assistantPart }
      );
      if (chatHistory.length > 10) chatHistory = chatHistory.slice(-10);
      
      return assistantPart;
    } catch (e) {
      console.warn('[AI Chat] Generation failed, using fallback', e.message);
      return getFallbackResponse(userMessage, language);
    }
  }

  function getFallbackResponse(msg, language) {
    const lower = msg.toLowerCase();
    const isEn = language === 'en';
    
    if (/restaurant|essen|food|eat|cuisine|restaurants|küche/i.test(lower)) {
      return isEn 
        ? 'La Jaula de Oro is a 5-minute walk — fantastic Canarian cuisine! They serve fresh seafood and local specialties. Would you like me to recommend more options? 🍽️'
        : 'Das La Jaula de Oro ist 5 Min. zu Fuß entfernt — fantastische kanarische Küche mit frischem Fisch und lokalen Spezialitäten. Soll ich weitere Optionen empfehlen? 🍽️';
    }
    if (/beach|strand|sea|meer|schwimmen|swim/i.test(lower)) {
      return isEn
        ? 'Costa Calma beach is just 300m away — ranked among the best in the Canary Islands! White sand, calm turquoise water, perfect for swimming year-round. 🏖️'
        : 'Der Strand Costa Calma ist nur 300m entfernt — einer der schönsten der Kanaren! Weißer Sand, türkises Wasser, perfekt zum Schwimmen das ganze Jahr. 🏖️';
    }
    if (/check.in|checkin|ankunft|arrival|check out/i.test(lower)) {
      return isEn
        ? 'Check-in is from 3:00 PM and check-out is by 11:00 AM. Early check-in is possible upon request — just let us know your arrival time! 🕒'
        : 'Check-in ist ab 15:00 Uhr, Check-out bis 11:00 Uhr. Früherer Check-in ist auf Anfrage möglich — teilen Sie uns einfach Ihre Ankunftszeit mit! 🕒';
    }
    if (/preis|price|cost|kosten|rate|zahlen|payment/i.test(lower)) {
      return isEn
        ? 'Master Suite from €180/night, Junior Suite from €130/night, or the entire villa from €380/night. All rates include WiFi, parking, and our AI concierge service. Check the booking section for availability! 💰'
        : 'Master Suite ab €180/Nacht, Junior Suite ab €130/Nacht oder die gesamte Villa ab €380/Nacht. Alle Preise inklusive WLAN, Parkplatz und KI-Concierge. Verfügbarkeit im Buchungsbereich prüfen! 💰';
    }
    if (/wifi|internet|wlan/i.test(lower)) {
      return isEn
        ? 'Yes, free high-speed WiFi is available throughout the villa — perfect for remote work or streaming! 📶'
        : 'Ja, kostenloses Highspeed-WLAN in der gesamten Villa verfügbar — perfekt für Remote-Arbeit oder Streaming! 📶';
    }
    if (/parking|parken|car|auto|vehicle/i.test(lower)) {
      return isEn
        ? 'Private parking is available directly at the villa — free of charge! No reservation needed. 🚗'
        : 'Ein privater Parkplatz ist direkt an der Villa verfügbar — kostenlos! Keine Reservierung nötig. 🚗';
    }
    if (/booking|buchung|reserv|available|verfügbar/i.test(lower)) {
      return isEn
        ? 'You can check availability and book directly through our website\'s booking section. All payments are processed securely via Stripe. Would you like me to help you choose the best room? 📅'
        : 'Sie können die Verfügbarkeit direkt im Buchungsbereich prüfen und buchen. Alle Zahlungen werden sicher über Stripe verarbeitet. Soll ich Ihnen helfen, das beste Zimmer auszuwählen? 📅';
    }
    if (/hello|hi|hallo|guten tag|hey/i.test(lower)) {
      return isEn
        ? 'Hello! 👋 I\'m your Villa Esmeralda AI concierge. I can help with restaurant tips, beach info, check-in details, and more. What can I do for you today?'
        : 'Hallo! 👋 Ich bin der KI-Concierge der Villa Esmeralda. Ich helfe mit Restaurant-Tipps, Strand-Infos, Check-in-Details und mehr. Was kann ich für Sie tun?';
    }
    if (/danke|thanks|thank/i.test(lower)) {
      return isEn
        ? 'You\'re welcome! 😊 Feel free to ask me anything else about your stay at Villa Esmeralda.'
        : 'Gerne! 😊 Fragen Sie mich alles über Ihren Aufenthalt in der Villa Esmeralda.';
    }
    return isEn
      ? 'I\'d be happy to help! You can ask me about restaurants, the beach, check-in details, pricing, WiFi, parking, or anything else about Villa Esmeralda. What would you like to know? 😊'
      : 'Ich helfe gerne! Fragen Sie mich nach Restaurants, dem Strand, Check-in, Preisen, WLAN, Parkplätzen oder allem rund um die Villa Esmeralda. Was möchten Sie wissen? 😊';
  }

  return { initPipeline, askAI, getFallbackResponse };
})();

// Make available globally
window.AI_CHAT = AI_CHAT;

// Auto-initialize when models are available
document.addEventListener('DOMContentLoaded', () => {
  // Preload model in background
  setTimeout(() => AI_CHAT.initPipeline(), 1000);
});