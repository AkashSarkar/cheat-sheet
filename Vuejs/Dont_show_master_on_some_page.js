//set a meta in route
export const routes = [
    {
        path: '/spa/interesting',
        component: InterestingComponent,
        name: 'interesting',
        meta: { dontShowToolbar: true }
    },

];

//check before entering route if any meta exists
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.dontShowToolbar)) {
        //set a variable in store to render master blade conditionally
        store.commit("setIsShowToolbar", false);
        next()
    } else {
        store.commit("setIsShowToolbar", true);
        next() // make sure to always call next()!
    }
})

//finally while calling the master component just check for the store variable
// <toolbar-component v-if="getIsShowToolbar"></toolbar-component>