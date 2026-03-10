<template>
  <BaseSelect
    :getApiRoute="ROLE_ENDPOINTS.selectable"
    select2
    label="Role"
    :error="errors.role_id"
    name="role_id"
    placeholder="Choose Role"
  />
</template>
<script>
import { ROLE_ENDPOINTS } from "../../../../data/endpoint";
</script>
