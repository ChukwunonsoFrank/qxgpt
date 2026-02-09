const pricingConfig = {
    broker: {
        color:"green",
        tiers: [
            { range: [0, 500], pricePerAccount: 6.00, priceOptionA: 0, afterFirstMonthMin: 3000, threshold: 500 },
            { range: [501, 2500], pricePerAccount: 5.50, priceOptionA: 0, threshold: 2500},
            { range: [2501, 5000], pricePerAccount: 5.00, priceOptionA: 0, threshold: 5000},
            { range: [5001, 10000], pricePerAccount: 4.50, priceOptionA: 0, threshold: 10000},
            { range: [10001, Infinity], pricePerAccount: 4.00, priceOptionA: 0, threshold: Infinity}
        ],
        account:{
            name: "Billable Account",
            definition: "A Live account that had at least one open trade during the billing month.",
        },
        demoAccounts:{
            name:"Billable Demo Account",
            price: 0.50
        },
        connectionOptions: {
            optionA: {
                name:"Bridge Connection And Custom Trading Setup",
                setupFee: 3000,
                pricePerAccount: 0,
                monthlySubscription: 0,
                benefits: ["TradeLocker Brand API","Custom Broker Back Office Setup","Custom Trading Setup","Web Sockets Access", "Unlimited Testing"]
            },
            optionB:{
                name:"No option",
                setupFee: 0,
                pricePerAccount: 0,
                monthlySubscription: 0,
                benefits: ["No option"]
            }
        },
        addOns: [
            { name: "Dealer Terminal", description: "View in real time what traders are trading, along with more information about their trades.", 
                price: 0, id: 'dealer-terminal' },
            { name: "Real-Time Trading Data Feed", description:"Enjoy exclusive servers, a dedicated database, faster execution, and enhanced back-office capabilities", 
                price: "custom", id: 'real-time-feed' },
            { name: "Cluster Separation", description:"Enjoy exclusive servers, a dedicated database, faster execution, and enhanced back-office capabilities.",
                price: "custom", id: 'cluster-separation' },
            { name: "Custom Integration", description:"Its custom integration allows you to connect your own trading platform to TradeLocker", 
                price: "custom", id: 'custom-integration' },   
        ]
    },
    prop: {
        color:"orange",
        tiers: [
            { range: [0, 500], pricePerAccount: 5.00, priceOptionA: 2.5, afterFirstMonthMin: 2000, threshold: 500 },
            { range: [501, 2500], pricePerAccount: 4.50, priceOptionA: 1.5, threshold: 2500},
            { range: [2501, 5000], pricePerAccount: 4.00, priceOptionA: 1.5, threshold: 5000},
            { range: [5001, 10000], pricePerAccount: 3.50, priceOptionA: 1.5, threshold: 10000},
            { range: [1001, Infinity], pricePerAccount: 3.00, priceOptionA: 1.5, threshold: Infinity }
        ],
        account:{
            name: "Active Prop Account",
            definition: "A prop account that has received the first deposit and has engaged in any activity on TradeLocker. Activities defining an active account include, but are not limited to, logging in, opening a trade, editing a trade, closing a trade, maintaining a trade, charting, and using the API.",
        },
        demoAccounts:{
            name:"Extra Demo Account Prop",
            price: 0
        },
        connectionOptions: {
            optionA: {
                name:"Simulated Live Environment",
                setupFee: 1000,
                pricePerAccount: 2.50,
                pricePerAccountAbove501: 1.50,
                description:"The more prop firms use this service, the lower the prices we can negotiate. Thanks to you, we have now negotiated the best simulated live environment and a done-for-you bridge service on the market.",
                benefits: ["Bridge and maintenance included","BackOffice Access","BackOffice Configuration","Custom Trading Setup","TradeLocker Brand API"]
            },
            optionB: {
                name:"Connection to your Bridge",
                setupFee: 3500,
                monthlySubscription: 1750,
                description:"We will connect with a bridge of your choice, set up your instruments, store the quotes, and maintain the route. You will need to cover the cost associated with the bridge and its maintenance.",
                benefits: ["BackOffice Access","BackOffice Configuration","Custom Trading Setup","TradeLocker Brand API"]
            }
        },
        addOns: [
            { name: "Dealer Terminal", description: "View in real time what traders are trading, along with more information about their trades.", 
                price: 0, id: 'dealer-terminal' },
            { name: "Real-Time Trading Data Feed", description:"Enjoy exclusive servers, a dedicated database, faster execution, and enhanced back-office capabilities", 
                price: "custom", id: 'real-time-feed' },
            { name: "Fraud Management", description:"Use the dashboard to efficiently detect fraud", 
                price: "custom", id: 'fraud-management-dashboard' },
            { name: "Cluster Separation", description:"Enjoy exclusive servers, a dedicated database, faster execution, and enhanced back-office capabilities.",
                price: "custom", id: 'cluster-separation' },
        ]
    }, 
    tournament: {
        color:"turquoise",
        tiers: [
            { range: [0, 9000], pricePerAccount: 0.50, priceOptionA: 0.25, afterFirstMonthMin: 0, threshold: 9000 },
            { range: [9001, 9200], pricePerAccount: 0.50, priceOptionA: 0.25, threshold: 9200},
            { range: [9201, 9300], pricePerAccount: 0.50, priceOptionA: 0.25, threshold: 9300},
            { range: [9301, 9400], pricePerAccount: 0.50, priceOptionA: 0.25, threshold: 9400},
            { range: [9401, Infinity], pricePerAccount: 0.50, priceOptionA: 0.25, threshold: Infinity }
        ],
        account:{
            name: "Active Tournament Account",
            definition: "A prop account that has received the first deposit and has engaged in any activity on TradeLocker. Activities defining an active account include, but are not limited to, logging in, opening a trade, editing a trade, closing a trade, maintaining a trade, charting, and using the API.",
        },
        demoAccounts:{
            name:"Extra Demo Account Tournament",
            price: 0
        },
        connectionOptions: {
            optionA: {
                name:"Simulated Live Environment",
                setupFee: 1000,
                pricePerAccount: 0.25,
                pricePerAccountAbove501: 0.25,
                description:"The more tourn firms use this service, the lower the prices we can negotiate. Thanks to you, we have now negotiated the best simulated live environment and a done-for-you bridge service on the market.",
                benefits: ["Bridge and maintenance included","BackOffice Configuration","Custom Trading Setup","TradeLocker Brand API"]
            },
            optionB: {
                name:"Connection to your Bridge",
                setupFee: 0,
                monthlySubscription: 0,
                description:"We will connect with a bridge of your choice, set up your instruments, store the quotes, and maintain the route. You will need to cover the cost associated with the bridge and its maintenance.",
                benefits: ["BackOffice Access","BackOffice Configuration","Custom Trading Setup","TradeLocker Brand API"]
            }
        },
        addOns: []
    }
};