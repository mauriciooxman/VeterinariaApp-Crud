# Database Schema Documentation

## Entity Relationship Diagram

```
┌─────────────────┐
│    CLIENTES     │
├─────────────────┤
│ id_cliente (PK) │
│ nombre          │
│ apellido        │
│ telefono        │
│ email           │
│ direccion       │
│ fecha_registro  │
└─────────┬───────┘
          │ 1
          │
          │ N
┌─────────▼───────┐
│    MASCOTAS     │
├─────────────────┤
│ id_mascota (PK) │
│ nombre          │
│ especie         │
│ raza            │
│ edad            │
│ peso            │
│ id_cliente (FK) │
│ fecha_registro  │
└─────────┬───────┘
          │ N
          │
          │ N
┌─────────▼───────┐       ┌──────────────────┐
│      CITAS      │◄──────┤  VETERINARIOS    │
├─────────────────┤   N   ├──────────────────┤
│ id_cita (PK)    │       │ id_veterinario PK│
│ id_mascota (FK) │       │ nombre           │
│ id_veterinario  │       │ apellido         │
│ fecha_cita      │       │ especialidad     │
│ motivo          │       │ telefono         │
│ estado          │       │ email            │
│ observaciones   │       │ fecha_contratac. │
└─────────┬───────┘       └──────────────────┘
          │ 1
          │
          │ N
┌─────────▼───────────┐
│   TRATAMIENTOS      │
├─────────────────────┤
│ id_tratamiento (PK) │
│ id_cita (FK)        │
│ descripcion         │
│ medicamentos        │
│ costo               │
│ fecha_tratamiento   │
└─────────────────────┘
```

## Relationships

1. **CLIENTES → MASCOTAS** (One to Many)
   - Un cliente puede tener múltiples mascotas
   - Una mascota pertenece a un solo cliente
   - Cascade on delete: Al eliminar un cliente, se eliminan sus mascotas

2. **MASCOTAS → CITAS** (Many to Many through CITAS)
   - Una mascota puede tener múltiples citas
   - Cascade on delete: Al eliminar una mascota, se eliminan sus citas

3. **VETERINARIOS → CITAS** (Many to Many through CITAS)
   - Un veterinario puede atender múltiples citas
   - Cascade on delete: Al eliminar un veterinario, se eliminan sus citas

4. **CITAS → TRATAMIENTOS** (One to Many)
   - Una cita puede tener múltiples tratamientos
   - Un tratamiento está asociado a una sola cita
   - Cascade on delete: Al eliminar una cita, se eliminan sus tratamientos

## CRUD Operations Available

Each entity supports complete CRUD operations:

### Clientes (Clients)
- **Create**: Add new clients with contact information
- **Read**: View all clients with their details
- **Update**: Edit client information
- **Delete**: Remove clients (cascades to their pets)

### Mascotas (Pets)
- **Create**: Register new pets linked to clients
- **Read**: View all pets with owner information (JOIN with clients)
- **Update**: Modify pet details including owner
- **Delete**: Remove pets (cascades to their appointments)

### Veterinarios (Veterinarians)
- **Create**: Add new veterinarians with specialties
- **Read**: View all veterinary staff
- **Update**: Edit veterinarian information
- **Delete**: Remove veterinarians (cascades to their appointments)

### Citas (Appointments)
- **Create**: Schedule appointments linking pets and veterinarians
- **Read**: View all appointments with pet, client, and vet info (multiple JOINs)
- **Update**: Modify appointment details and status
- **Delete**: Cancel appointments (cascades to treatments)

### Tratamientos (Treatments)
- **Create**: Record treatments for specific appointments
- **Read**: View all treatments with related appointment info (multiple JOINs)
- **Update**: Edit treatment details and costs
- **Delete**: Remove treatment records

## Sample Queries Used

### Read Mascotas with Cliente Info (JOIN)
```sql
SELECT m.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido 
FROM mascotas m
LEFT JOIN clientes c ON m.id_cliente = c.id_cliente
ORDER BY m.nombre
```

### Read Citas with Multiple Joins
```sql
SELECT c.*, 
       m.nombre as mascota_nombre, m.especie,
       v.nombre as vet_nombre, v.apellido as vet_apellido,
       cl.nombre as cliente_nombre, cl.apellido as cliente_apellido
FROM citas c
LEFT JOIN mascotas m ON c.id_mascota = m.id_mascota
LEFT JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
LEFT JOIN clientes cl ON m.id_cliente = cl.id_cliente
ORDER BY c.fecha_cita DESC
```

### Read Tratamientos with Multiple Joins
```sql
SELECT t.*, 
       c.fecha_cita, c.motivo,
       m.nombre as mascota_nombre,
       v.nombre as vet_nombre, v.apellido as vet_apellido
FROM tratamientos t
LEFT JOIN citas c ON t.id_cita = c.id_cita
LEFT JOIN mascotas m ON c.id_mascota = m.id_mascota
LEFT JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
ORDER BY t.fecha_tratamiento DESC
```

## Security Features

- **PDO Prepared Statements**: All queries use prepared statements to prevent SQL injection
- **Parameter Binding**: All user input is bound to parameters safely
- **HTML Sanitization**: Output is sanitized with `htmlspecialchars()` to prevent XSS
- **Cascade Deletes**: Foreign key constraints maintain referential integrity
- **Input Validation**: Required fields and data types are validated in forms
