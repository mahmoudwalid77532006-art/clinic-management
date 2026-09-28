Enum user_role {
  admin
  doctor
  receptionist
  patient
}

Enum gender_type {
  male
  female
}

Enum appointment_status {
  pending
  confirmed
  completed
  cancelled
  no_show
}

Table users {
  id bigint [pk, increment]
  name varchar
  email varchar [unique]
  phone varchar [null]
  password varchar
  role user_role
  created_at timestamp
  updated_at timestamp
}

Table doctors {
  id bigint [pk, increment]
  user_id bigint [unique, ref: - users.id]
  specialty varchar
  bio text [null]
  slot_duration_minutes int [default: 30]
  is_active boolean [default: true]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp [null]
}

Table patients {
  id bigint [pk, increment]
  user_id bigint [null, unique, ref: - users.id]
  full_name varchar
  phone varchar
  date_of_birth date [null]
  gender gender_type [null]
  address varchar [null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp [null]
}

Table services {
  id bigint [pk, increment]
  name varchar
  description text [null]
  price decimal(10,2)
  duration_minutes int
  is_active boolean [default: true]
  created_at timestamp
  updated_at timestamp
}

Table doctor_service {
  doctor_id bigint [ref: > doctors.id]
  service_id bigint [ref: > services.id]

  indexes {
    (doctor_id, service_id) [pk]
  }
}

Table doctor_schedules {
  id bigint [pk, increment]
  doctor_id bigint [ref: > doctors.id]
  day_of_week tinyint [note: '0 = Sunday ... 6 = Saturday']
  start_time time
  end_time time
  is_active boolean [default: true]
  created_at timestamp
  updated_at timestamp
}

Table doctor_time_offs {
  id bigint [pk, increment]
  doctor_id bigint [ref: > doctors.id]
  date date
  start_time time [null, note: 'null = whole day']
  end_time time [null]
  reason varchar [null]
  created_at timestamp
  updated_at timestamp
}

Table appointments {
  id bigint [pk, increment]
  patient_id bigint [ref: > patients.id]
  doctor_id bigint [ref: > doctors.id]
  service_id bigint [ref: > services.id]
  appointment_date date
  start_time time
  end_time time
  price decimal(10,2) [note: 'snapshot of service price at booking time']
  status appointment_status [default: 'pending']
  cancellation_reason varchar [null]
  created_by bigint [ref: > users.id]
  created_at timestamp
  updated_at timestamp

  indexes {
    (doctor_id, appointment_date, start_time)
    patient_id
    status
  }
}

Table visits {
  id bigint [pk, increment]
  appointment_id bigint [unique, ref: - appointments.id]
  patient_id bigint [ref: > patients.id]
  doctor_id bigint [ref: > doctors.id]
  diagnosis text [null]
  notes text [null]
  created_at timestamp
  updated_at timestamp
}

Table prescriptions {
  id bigint [pk, increment]
  visit_id bigint [ref: > visits.id]
  medication_name varchar
  dosage varchar
  frequency varchar
  duration varchar
  instructions text [null]
  created_at timestamp
  updated_at timestamp
}
