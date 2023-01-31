<template>
    <div v-for="highschool in highSchool" class="columns">
        <div class="field column">
            <label class="label">{{ $t('user_setting.info.school_name') }}:</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-success" type="text" name="highschool_name" v-model="highschool.school_name">
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-school"></i>
                </span>
            </div>
        </div>
        <div class="field column">
            <label class="label">{{ $t('user_setting.info.start_year') }}:</label>
            <div class="control">
                <div class="select">
                    <select class="year-select" name="highschool_start" v-model="highschool.start_year">
                        <option v-for="year in years">{{ year }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="field column">
            <label class="label">{{ $t('user_setting.info.end_year') }}:</label>
            <div class="control">
                <div class="select">
                    <select class="year-select" name="highschool_start" v-model="highschool.end_year">
                        <option v-for="year in years">{{ year }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['schools'],
    data() {
        return {
            
        }
    },
    methods: {
        addSelection() {

        }
    }
}
</script>