import { defineStore } from 'pinia'

export const useDemoStore = defineStore('DemoStore', {
    // Think as data
    state: () => {
        return {
            items: []
        };
    },

    // Think as computed properties
    getters: {
        totalItems() {
            return this.items.length;
        }
    },

    // Think as methods
    actions: {
        // load initial data
        fill() {
            this.items = [
                {
                    id: 1,
                    name: 'Item 1',
                    status: 'active'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    status: 'active'
                },
                {
                    id: 3,
                    name: 'Item 3',
                    status: 'active'
                }
            ];
        },

        addItems(count, item) {
            count = parseInt(count);
            for(let idx = 0; idx < count; idx++) {
                this.items.push({...item});
            }
        }
    }
});