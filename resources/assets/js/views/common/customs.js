/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./../../bootstrap');

import Vue from 'vue';
import DashboardPlugin from './../../plugins/dashboard-plugin';
import Global from './../../mixins/global';

import CustomForm from './../../plugins/custom-form';
import BulkAction from './../../plugins/bulk-action';
import {getQueryVariable} from './../../plugins/functions';
import CustomSelect2 from './../../components/v2/CustomSelect2';

// plugin setup
Vue.use(DashboardPlugin);

const customs = new Vue({
    el: '#form-select-members',

    components: {
        CustomSelect2,
    },

    mixins: [
        Global
    ],

    data: function () {
        return {
            form: new CustomForm('project'),
            bulk_action: new BulkAction('projects'),
        };
    },

    mounted() {
        console.log('mounted----')
        let form = new CustomForm('project');
        let action = new BulkAction('projects');
        this.form = form;
        this.action = action;
    },

    methods:{
    }
});
