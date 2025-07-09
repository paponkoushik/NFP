<template>
    <FormWizard :validation-schema="validationSchema" :maxStep="4" @stepChange="handleSteps" @submit="onSubmit">
        <transition name="fade" mode="out-in">
            <component :is="components[currentStepIdx]" />
        </transition>

        <!-- <FormStep>
            <VField name="summary" type="text" placeholder="Type your Full name" />
            <ErrorMessage name="summary" />

            <VField name="details" type="text" placeholder="Type your email" />
            <ErrorMessage name="details" />
        </FormStep>

        <FormStep>
            <VField name="name" type="text" placeholder="Type your Full name" />
            <ErrorMessage name="name" />

            <VField name="email" type="email" placeholder="Type your email" />
            <ErrorMessage name="email" />
        </FormStep>

        <FormStep>
            <VField
                name="password"
                type="password"
                placeholder="Type a strong one"
            />
            <ErrorMessage name="password" />

            <VField
                name="confirmPass"
                type="password"
                placeholder="Confirm your password"
            />
            <ErrorMessage name="confirmPass" />
        </FormStep>

        <FormStep>
            <VField name="favoriteDrink" as="select">
                <option>Select a drink</option>
                <option value="coffee">Coffee</option>
                <option value="tea">Tea</option>
                <option value="soda">Soda</option>
            </VField>
            <ErrorMessage name="favoriteDrink" />
        </FormStep> -->
    </FormWizard>
</template>