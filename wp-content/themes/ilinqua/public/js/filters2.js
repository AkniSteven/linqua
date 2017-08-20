Vue.component('list', {
	template: '#list-template',
	props: ['list']
});

Vue.component('list-header', {
	template: '#list-header',
	props: ['list-header']
});

var vm = new Vue({
	el: 'body',
	data: {
		users: ["freecodecamp", "storbeck", "terakilobyte", "habathcx","RobotCaleb","thomasballinger","noobs2ninjas","beohoff","test_channel","cretetion","sheevergaming","TR7K","OgamingSC2","ESL_SC2"],
		// users: ['freecodecamp', 'storbeck', 'terakilobyte'],
		channelRes: [],
		obj: {},
		status: ['all','online', 'offline'],
		reverse: true,
		listStyle: '',
		isA: false,
		isB: true,
		displayMode: 0,
		classStyle: ''
	},
	computed: {
		currentStyle: function () {
			if (this.displayMode === 0) {
				this.listStyle = 'list-view'
			} else {
				this.listStyle = 'list-box'
			}

			return this.listStyle
		},
		currentClass: function () {
			if (this.displayMode === 0) {
				this.classStyle = 'view'
			} else {
				this.classStyle = 'box'
			}

			return this.classStyle
		}
	},
	ready: function () {
		this.getChannel()
		this.showList()

	},
	methods: {
		getChannel: function () {
			var instance = this
			var resnow = this.channelRes

			this.users.forEach(function(channel, index){
				instance.$http.get(instance.makeUrl('streams', channel)).then((response) => {
					instance.$http.get(instance.makeUrl('channels', channel)).then((data) => {
						if (response.json().stream === null || response.json().stream === undefined) {
							instance.channelRes.$set(index,{status: 'offline', name: data.json().name, desc: data.json().status, img: data.json().logo, url: data.json().url})
						} else {
							instance.channelRes.$set(index,{status: 'online', name: data.json().name, desc: data.json().status, img: data.json().logo, url: data.json().url})
						}
					}, (data) => {
						console.log(data)
					})
				}, (response) => {
					console.log(response)
				})
			})
		},
		makeUrl: function (type, name) {
			return 'https://api.twitch.tv/kraken/' +type+ '/' +name+ '?client_id=5j0r5b7qb7kro03fvka3o8kbq262wwm';
		},
		showList: function () {
			if (this.isA) {
				this.isA = this.isA
				this.isB = this.isB
			} else {
				this.isA = !this.isA
				this.isB = !this.isB
			}
		},
		changeClass: function () {
			this.reverse = !this.reverse
		},
		getClass: function (option) {
			this.displayMode = option;
		},
	},
	filters: {
		status: function (account) {
			if (this.status == 'all') {
				return account
			}

			return account.filter(function(account) {
				return account.status == this.status
			}.bind(this))
		}
	}
})