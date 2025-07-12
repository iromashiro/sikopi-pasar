## Project Codename: "SIKOPI PASAR"
## Date Created: 6/12/2025

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [System Context](#system-context)  
3. [Container Architecture](#container-architecture)
4. [Component Design](#component-design)
5. [Data Architecture](#data-architecture)
6. [API Design](#api-design)
7. [Security Architecture](#security-architecture)
8. [Scalability and Performance](#scalability-performance)
9. [Implementation Guidance](#implementation-guidance)

---

## 1. Project Overview

### High-level Business Objectives
- Digitalize traditional market levy collection processes in Muara Enim Regency.
- Enhance transparency, accountability, and efficiency in market levy management.
- Increase Regional Original Revenue (PAD) through optimized levy collection.
- Provide clear and timely levy information to market traders.

### Key Stakeholders and User Personas
- **Dinas Perindustrian, Perdagangan, dan ESDM (Admin)**
  - Manages trader data, levy calculations, and payment reconciliations.
  - Monitors levy payments, generates reports, and audits transactions.
- **Market Traders**
  - Access levy information, payment history, and digital receipts.
  - Receive notifications for payment deadlines.
  - Perform levy payments (initially cash-based).

### Scope Boundaries and Constraints
- Monolithic web application built with Laravel 11.
- PostgreSQL 17 as the database.
- Frontend using Bootstrap 5, HTML5, Blade templating, and AlpineJS.
- Initial cash-based payments, with future flexibility for digital payment integration.
- Offline capability considerations for intermittent connectivity.

### Critical Success Factors
- Accurate trader data and levy calculations.
- User-friendly interface for both admin and traders.
- Timely and accurate notifications.
- Secure data management and compliance with regulations.
- Robust audit trail and reconciliation processes.

### Timeline Considerations
- MVP development within 3 months.
- Iterative development based on user feedback.

### Integration Requirements with Existing Systems
- No external integrations initially.
- Flexible architecture for future integrations (e.g., financial systems, SMS gateways).

---

## 2. Functional Requirements

### Core Business Processes to be Implemented
- Trader data management by admin.
- Customizable levy calculation formula.
- Transparent levy information display for traders.
- Cash-based payment recording and reconciliation.
- Digital receipt generation after payment.
- Automated notifications for levy payment deadlines.
- Comprehensive audit logging of administrative actions.

### User Journeys and Workflows

#### Admin (Dinas Perindag)
- Login to admin dashboard.
- CRUD operations for trader data.
- Define and customize levy calculation formulas.
- Assign levy amounts to traders.
- Record and reconcile cash payments.
- Generate digital receipts.
- Monitor payment statuses and generate reports.
- Manage and trigger notifications.

#### Market Traders
- Login to trader dashboard.
- View assigned levy amounts and payment deadlines.
- View payment history, status, and digital receipts.
- Receive notifications regarding payment deadlines.

### Data Capture and Processing Needs
- Trader Data: kiosk name, kiosk number, trader name, trader NIK, business type, trader address.
- Levy Data: levy amount, payment status, due date, payment history, receipt number.

### Reporting and Analytics Requirements
- Daily, weekly, monthly, and annual levy payment reports.
- Reports on overdue payments.
- Basic analytics dashboard for admin.

### Administrative Capabilities
- User management (admin and traders).
- Master data management (traders, kiosks).
- Levy calculation formula configuration.
- Notification management.
- Audit log viewing and management.

### Notification and Communication Requirements
- In-app notifications (dashboard notifications).
- Email notifications (prepared for future implementation).
- SMS notifications (prepared for future implementation).

---

## 3. Non-Functional Requirements

### Performance Expectations
- Maximum response time per page: 2 seconds.
- Optimized database queries for performance.

### Scalability Requirements
- Capable of handling thousands of traders without significant performance degradation.
- Database indexing and partitioning strategies for historical data.

### Security Needs and Compliance Standards
- Compliance with Indonesian Personal Data Protection Law (UU PDP).
- OWASP security standards implementation.
- Role-Based Access Control (RBAC).
- CSRF protection, input sanitization, and secure session management.

### Availability and Reliability Expectations
- Minimum uptime: 99%.
- Automated daily database backups.
- Disaster recovery procedures clearly defined.

### Maintainability Considerations
- Clear, documented, and maintainable codebase.
- Adherence to Laravel coding standards and best practices.
- Automated testing and code review processes.

### Localization and Internationalization Needs
- Application language: Indonesian.

### Accessibility Requirements
- Compliance with Web Content Accessibility Guidelines (WCAG 2.1 AA).

### Browser/Device Compatibility
- Modern browsers compatibility (Chrome, Firefox, Edge, Safari).
- Responsive design for desktop, tablet, and mobile devices.

---

## 4. Technical Guidelines

### Recommended Laravel Version and Key Packages
- Laravel 11.x (latest stable version).
- Laravel Breeze or Jetstream for authentication scaffolding.
- Spatie Laravel Permission for RBAC.
- Laravel Notifications for notification management.
- Laravel Excel for bulk data import/export.
- Laravel Telescope for monitoring and debugging.

### Suggested Architectural Patterns
- MVC architecture with Repository and Service Layer patterns.
- Blade components for reusable UI elements.
- Event-driven architecture for notifications and audit logging.

### Database Design Considerations
- PostgreSQL 17, normalized to at least 3NF.
- Indexing for frequently queried columns and foreign keys.
- Laravel migrations for schema management.
- Transaction management for financial operations.

### API Design Principles
- RESTful API structure (prepared for future integrations).
- JSON data format standard.
- API versioning and OpenAPI/Swagger documentation.

### Authentication and Authorization Approach
- Laravel built-in authentication (Laravel Breeze/Jetstream).
- RBAC implementation via Spatie Laravel Permission.
- Secure password and session management policies.

### File Handling and Storage Recommendations
- Local storage initially, structured directories for file uploads.

### Caching Strategy Recommendations
- Redis or file-based caching for frequently accessed data.

### Queue and Job Processing Needs
- Laravel Queue for asynchronous notification dispatch.

---

## 5. Implementation Considerations

### Phasing Recommendations
- **Phase 1 (MVP)**: Trader data management, levy calculation, notifications, manual cash payments, digital receipts, audit logging.

### Testing Requirements
- Unit testing for core business logic.
- Integration testing for critical features.
- User Acceptance Testing (UAT) with stakeholders.

### Deployment Strategy Suggestions
- CI/CD pipeline using GitHub Actions or GitLab CI.
- Environment-specific configuration management.
- Database migration safety procedures and rollback strategies.

### Monitoring and Logging Needs
- Laravel logging for error tracking and critical activities.
- Laravel Telescope for performance monitoring.
- Defined KPIs and alerting thresholds.

### Backup and Disaster Recovery Considerations
- Automated daily database backups.
- Weekly application file backups.
- Clear disaster recovery and data retention policies.

### Documentation Requirements
- Technical documentation (README, installation, configuration).
- User manuals for admin and traders.

---

This enhanced prompt addresses previously identified gaps, providing detailed guidance on levy calculation, payment reconciliation, audit logging, offline capabilities, and comprehensive technical recommendations, ensuring the SIKOPI PASAR system meets enterprise standards and stakeholder expectations.

System Specification  
Project Codename: "SIKOPI PASAR"  
Date: 12 Jun 2025  
Author: System-Analysis Team  

======================== 1. EXECUTIVE SUMMARY ========================  
Project Objective  
• Replace manual levy collection in Muara Enim Regency markets with a secure, transparent, Laravel-based web application.  
• Deliver an MVP in 3 months, capable of handling thousands of traders, cash-payment recording, automated notifications, audit trail and basic analytics.  

Stakeholders & User Groups  
• Primary Admin: Dinas Perindustrian, Perdagangan & ESDM staff (≈10 users).  
• Secondary Users: Market traders (≈4 000 active).  
• Technical Stakeholders: Regency ICT division, security/compliance officers, future payment-gateway partners.  

Scope Boundaries  
• Monolithic Laravel 11 application + PostgreSQL 17 DB.  
• Browser-based responsive UI (Bootstrap 5/Blade/AlpineJS).  
• Cash payments only in MVP; digital payments and offline PWA features deferred to Phase 2.  
• No third-party integration in Phase 1, but API façade prepared.  

Critical Success Factors  
• ≤2 s average page response; 99 % uptime.  
• 100 % levy calculation accuracy vs. approved formula.  
• Audit log immutability and full trace coverage.  
• Positive UAT score (≥85 % "satisfied" responses) from both admin & traders.  

High-Level Timeline  
• M0   Requirements freeze & architecture  
• M1   Core data model, authentication, admin CRUD  
• M2   Levy engine, notifications, audit log, trader dashboard  
• M3   UAT, performance hardening, production launch  

======================== 2. DETAILED REQUIREMENTS =====================  

2.1 Functional Requirements  

FR-1 User Management  
 FR-1.1 Admin can create, edit, disable Admin or Trader accounts.  
 FR-1.2 Role-Based Access Control enforced via Spatie Permission.  

FR-2 Trader & Kiosk Registry  
 FR-2.1 Admin maintains kiosks (market, kiosk #†, size, category).  
 FR-2.2 Admin links one or more kiosks to a Trader record (NIK-verified).  
 FR-2.3 History of kiosk-trader assignment retained (no destructive edits).  

FR-3 Levy Calculation & Assignment  
 FR-3.1 Admin defines formula elements: base rate, category multiplier, area multiplier, custom overrides.  
 FR-3.2 System generates monthly levy lines per active kiosk-trader pair (cron job "levy:generate" at 00:05 on the 1st).  
 FR-3.3 Admin can regenerate levies for selected kiosks after formula change (with versioned audit trail).  

FR-4 Payment Recording & Reconciliation  
 FR-4.1 Admin records cash payment (date, amount, collector name, receipt #).  
 FR-4.2 Payment status auto-transitions: Pending → Paid (amount ≥ levy); Partial where amount < levy.  
 FR-4.3 Daily reconciliation screen totals cash vs. expected and flags variances.  

FR-5 Digital Receipt  
 FR-5.1 Upon payment, PDF receipt generated (QR code, receipt #, kiosk #, levy period, amount, officer signature).  
 FR-5.2 Traders may download receipts from dashboard.  

FR-6 Notifications  
 FR-6.1 System triggers in-app notifications:  
  • Levy generated (D-7 to due).  
  • Due today.  
  • Overdue (D+1 recurring weekly).  
 FR-6.2 Notification queue processed asynchronously (Redis queue).  
 FR-6.3 Template management UI for Admin (subject, body, variables).  

FR-7 Reporting & Analytics  
 FR-7.1 Pre-built reports: Daily, Weekly, Monthly, Annual collection; Overdue list.  
 FR-7.2 Pivot chart dashboard: paid vs. outstanding, top defaulters, collection trend.  
 FR-7.3 Export to XLSX/CSV via Laravel Excel.  

FR-8 Audit Logging  
 FR-8.1 All create/update/delete actions on core entities logged (user_id, action, before, after, IP, UA, timestamp).  
 FR-8.2 Immutable storage (append-only table, restricted delete).  
 FR-8.3 Admin UI with filters & CSV export.  

FR-9 System Administration  
 FR-9.1 Configurable markets list, levy due-day (1-31), grace period, notification cadence.  
 FR-9.2 Application settings cached (config_cache).  

2.2 User Workflows (Happy Path)  
A. Admin creates new trader ➜ assigns kiosk(s) ➜ formula already set ➜ cron generates levy ➜ notification sent ➜ trader pays cash at counter ➜ admin records payment ➜ receipt auto-issued ➜ dashboard updated.  
B. Trader logs in ➜ views current levy card ➜ sees D-7 reminder badge ➜ pays ➜ receipt download.  

2.3 Business Rules & Validation  
BR-1 NIK must be 16 digits, checksum validated.  
BR-2 A kiosk cannot be assigned to >1 active trader at the same time.  
BR-3 Levy amount = ROUND( base_rate × category_mult × area_mult ) + custom_override.  
BR-4 Payment date must be ≥ levy period start.  
BR-5 A receipt # is unique system-wide (format: "RCPT-YYYYMM-####").  

2.4 User Interface Requirements  
UI-1 Responsive admin panel with sidebar navigation (trader, kiosk, levies, reports, settings).  
UI-2 Trader dashboard:  
 • Card with current levy, due date, status badge.  
 • Table of historical payments with receipt links.  
UI-3 All tables provide search, sort, pagination (AlpineJS).  
UI-4 WCAG 2.1 AA: colour contrast, skip links, aria-labels.  

2.5 Data Requirements  

Entities & Key Attributes  
• users (id, name, email, password, role_id, last_login_at)  
• traders (id, nik, name, address, phone, status)  
• kiosks (id, market_id, kiosk_no, category, area_m2, status)  
• trader_kiosk (id, trader_id, kiosk_id, start_date, end_date)  
• levies (id, trader_kiosk_id, period_month, due_date, amount, status, formula_version)  
• payments (id, levy_id, paid_at, amount, method, receipt_no, collector_name)  
• receipts (id, payment_id, pdf_path, generated_at)  
• notification_logs (id, user_id, channel, template_id, sent_at, success)  
• audit_logs (id, user_id, action, entity, before_json, after_json, ip, ua, ts)  
• settings (key, value, cast_type, updated_by)  
(All PKs serial, FK constraints, soft-deletes only on non-financial tables.)  

Relationships  
Trader 1-M Trader_Kiosk; Kiosk 1-M Trader_Kiosk; Trader_Kiosk 1-M Levies; Levy 1-1..M Payments; Payment 1-1 Receipt.  

Data Retention  
• Financial data & audit logs retained 10 years (regulation).  
• Soft-deleted trader records visible only to SuperAdmin.  

2.6 Integration Requirements (Phase 1 placeholder)  
• REST API v1 prefixed /api/v1, stateless token auth (Laravel Sanctum) exposed for future payment gateway & mobile app.  
• Swagger docs auto-generated via Laravel-OpenAPI.  

======================== 3. NON-FUNCTIONAL REQUIREMENTS ==============  

Performance  
• P95 page response ≤2 s @ 200 concurrent users.  
• Background jobs <15 s latency.  

Scalability  
• Horizontal DB read replicas optional; use table partitioning on levies by year after 2 M rows.  

Security  
• UU PDP compliance: explicit consent banner, data-processing registry, right-to-be-forgotten for non-financial PII.  
• HTTPS only, HSTS 1 year.  
• OWASP Top-10 mitigations incl. rate-limiting (Laravel throttle) and Content-Security-Policy.  

Availability & Reliability  
• Dockerised deployment on HA Kubernetes cluster (min. 2 pods).  
• Daily logical dump + weekly full snapshot. RTO ≤ 4 h, RPO ≤ 1 h.  

Maintainability  
• PSR-12 code style; static analysis via Larastan level 6; 90 % unit-test coverage of service layer.  

Accessibility  
• All forms label-associated; focus indicators visible; table row highlights WCAG AA compliant colours.  

Browser Support  
• Chrome/Edge/Firefox/Safari last 2 versions; graceful degradation on IE 11 not required.  

======================== 4. CONSTRAINTS & ASSUMPTIONS ===============  

Technical  
• Monolithic architecture—no microservices until trader volume >20 k.  
• Redis available for queue & cache.  

Business  
• Cash remains primary payment in 2025 fiscal year.  
• Market office provides reliable LAN/Wi-Fi; but some traders use 3G/4G.  

Regulatory  
• Financial records must be exportable in CSV for BPK audit.  

Resource  
• Team: 1 PM, 1 BA, 2 Backend, 1 Frontend, 1 QA, 1 DevOps.  
• Budget capped at IDR 750 M for MVP.  

Assumptions  
• No multi-tenant requirement; single database covers all markets in the regency.  
• Traders own smartphones capable of modern browsers.  

======================== 5. SUCCESS CRITERIA =========================  

Functional Acceptance  
AC-1 Admin can generate levy for all traders in <5 min with zero error difference vs. manual sheet.  
AC-2 Trader sees correct levy amount and due date immediately after generation.  
AC-3 Payment entry instantly updates levy status and issues downloadable receipt.  
AC-4 Notifications delivered to ≥95 % of users within 2 min of schedule.  

Performance & Quality  
• Load test at 500 RPS sustains ≤2 s avg response.  
• 0 critical & ≤2 major bugs open at Go-Live.  

User Satisfaction  
• Post-launch survey: ≥85 % of admins rate usability ≥4/5; ≥80 % traders rate transparency ≥4/5.  

Business Metrics  
• Levy collection rate improves ≥15 % vs. previous year within 6 months.  
• Discrepancies in manual records reduced to <1 %.  

===============================================================  
END OF SPECIFICATION

# System Architecture Design: SIKOPI PASAR (Market Levy Digitalization System)

## 1. Executive Summary

### High-level Architecture Overview
The SIKOPI PASAR system will be implemented as a monolithic Laravel 11 application with a PostgreSQL 17 database, following a layered architecture pattern with clear separation of concerns. The system will utilize a service-repository pattern to encapsulate business logic and data access, with event-driven components for notifications and audit logging.

### Key Technology Decisions
- **Backend Framework**: Laravel 11 (latest stable version)
- **Database**: PostgreSQL 17 with partitioning strategy for historical data
- **Frontend**: Bootstrap 5, Blade templating, AlpineJS for interactive components
- **Authentication**: Laravel Breeze with customizations for multi-role support
- **Authorization**: Spatie Laravel Permission for RBAC implementation
- **Caching**: Redis for application cache and queue processing
- **PDF Generation**: Laravel Dompdf for digital receipts
- **Reporting**: Laravel Excel for export functionality
- **API Documentation**: Laravel OpenAPI/Swagger

### Critical Design Patterns Utilized
- Repository Pattern for data access abstraction
- Service Layer Pattern for business logic encapsulation
- Observer Pattern for audit logging and notifications
- Factory Pattern for receipt generation
- Strategy Pattern for levy calculation formulas
- Command Pattern for scheduled tasks and background jobs

### Core Architectural Principles Applied
- Separation of concerns across layers
- Single responsibility principle for services and repositories
- Immutable audit trail for financial transactions
- Defense in depth for security controls
- Fail-safe defaults for critical operations
- Optimistic concurrency for data integrity

### Business Requirements Addressed
- Transparent and accurate levy management
- Secure and auditable financial transactions
- Flexible levy calculation formulas
- Comprehensive notification system
- Detailed reporting and analytics
- Complete audit trail for compliance

## 2. System Context

### System Boundaries and External Interfaces
The SIKOPI PASAR system operates as a standalone application initially, with defined boundaries for future integration:

```
┌─────────────────────────────────────────────────────────────┐
│                     SIKOPI PASAR SYSTEM                     │
│                                                             │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────────┐  │
│  │ Admin Portal│    │Trader Portal│    │ Reporting Engine│  │
│  └─────────────┘    └─────────────┘    └─────────────────┘  │
│          │                │                     │           │
│  ┌─────────────────────────────────────────────────────┐   │
│  │              Core Business Services                  │   │
│  └─────────────────────────────────────────────────────┘   │
│          │                │                     │           │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────────┐  │
│  │ Data Access │    │Notification │    │ Audit & Security│  │
│  │   Layer     │    │   Service   │    │     Services    │  │
│  └─────────────┘    └─────────────┘    └─────────────────┘  │
│          │                │                     │           │
└──────────┼────────────────┼─────────────────────┼───────────┘
           │                │                     │
┌──────────┼────────────────┼─────────────────────┼───────────┐
│          ▼                ▼                     ▼           │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────────┐  │
│  │ PostgreSQL  │    │    Redis    │    │  File Storage   │  │
│  │  Database   │    │ Cache/Queue │    │                 │  │
│  └─────────────┘    └─────────────┘    └─────────────────┘  │
│                                                             │
│                  INFRASTRUCTURE LAYER                        │
└─────────────────────────────────────────────────────────────┘
```

### User Personas and System Interactions
1. **Admin Users (Dinas Perindustrian, Perdagangan, dan ESDM staff)**
   - Manage trader and kiosk data
   - Configure levy calculation formulas
   - Record cash payments and reconcile accounts
   - Generate reports and analyze collection performance
   - Manage notification templates and system settings

2. **Market Traders**
   - View assigned levy amounts and payment deadlines
   - Access payment history and digital receipts
   - Receive notifications about upcoming and overdue payments

### External System Integrations (Future)
While not part of the initial MVP, the architecture will support future integrations with:
- SMS gateway services for trader notifications
- Digital payment gateways (e-wallet, bank transfers)
- Regional financial management systems
- National ID verification services (for NIK validation)

### Deployment Context and Environment
The application will be deployed in a containerized environment:
- Docker containers orchestrated with Kubernetes
- Minimum of 2 application pods for high availability
- Separate database instance with daily backups
- Redis instance for caching and queue processing
- Nginx as reverse proxy with SSL termination
- CDN for static assets

## 3. Container Architecture

### High-level Component Diagram

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           SIKOPI PASAR SYSTEM                            │
│                                                                         │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────────────┐  │
│  │                 │  │                 │  │                         │  │
│  │  Presentation   │  │  Application    │  │  Domain                 │  │
│  │  Layer          │  │  Layer          │  │  Layer                  │  │
│  │                 │  │                 │  │                         │  │
│  │  - Web Routes   │  │  - Controllers  │  │  - Services             │  │
│  │  - API Routes   │  │  - Requests     │  │  - Events               │  │
│  │  - Middleware   │  │  - Resources    │  │  - Listeners            │  │
│  │  - Views        │  │  - Jobs         │  │  - Notifications        │  │
│  │                 │  │                 │  │                         │  │
│  └────────┬────────┘  └────────┬────────┘  └──────────┬──────────────┘  │
│           │                    │                      │                  │
│           │                    │                      │                  │
│  ┌────────▼────────┐  ┌────────▼────────┐  ┌──────────▼──────────────┐  │
│  │                 │  │                 │  │                         │  │
│  │  Infrastructure │  │  Security       │  │  Data Access            │  │
│  │  Layer          │  │  Layer          │  │  Layer                  │  │
│  │                 │  │                 │  │                         │  │
│  │  - Logging      │  │  - Auth         │  │  - Models               │  │
│  │  - Caching      │  │  - Permissions  │  │  - Repositories         │  │
│  │  - Queue        │  │  - Audit        │  │  - Eloquent             │  │
│  │  - Storage      │  │                 │  │                         │  │
│  │                 │  │                 │  │                         │  │
│  └─────────────────┘  └─────────────────┘  └─────────────────────────┘  │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Major System Containers/Services

1. **Web Application Container**
   - Handles HTTP requests and responses
   - Renders views for admin and trader interfaces
   - Processes form submissions and API requests
   - Manages authentication and session state

2. **Background Worker Container**
   - Processes queued jobs (notifications, receipt generation)
   - Executes scheduled tasks (levy generation, reminders)
   - Handles long-running operations asynchronously

3. **Database Container**
   - Stores all application data
   - Manages transactions and data integrity
   - Implements partitioning for historical data

4. **Redis Container**
   - Provides caching for frequently accessed data
   - Manages job queues for background processing
   - Supports session storage for horizontal scaling

5. **Storage Container**
   - Stores generated PDF receipts
   - Manages uploaded files (trader documents, etc.)
   - Provides backup storage for exports

### Interaction Patterns Between Containers

```
┌─────────────┐      HTTP      ┌─────────────┐
│   Client    │◄──────────────►│     Web     │
│  Browsers   │                │ Application │
└─────────────┘                └──────┬──────┘
                                      │
                                      │ SQL
                                      ▼
┌─────────────┐                ┌─────────────┐
│  Background │◄───Redis Queue─┤  Database   │
│   Worker    │                │             │
└──────┬──────┘                └─────────────┘
       │                              ▲
       │                              │
       │                              │
       │         ┌─────────────┐      │
       └────────►│    Redis    │──────┘
                 │  Cache/Queue│
                 └─────────────┘
```

### Technology Stack Selections with Rationales

1. **Laravel 11**
   - Rationale: Mature PHP framework with robust ecosystem, excellent documentation, and strong security features. Version 11 provides the latest performance improvements and security enhancements.

2. **PostgreSQL 17**
   - Rationale: Enterprise-grade relational database with advanced features like table partitioning, JSON support, and robust transaction handling. Superior to MySQL for complex financial data with ACID compliance.

3. **Redis**
   - Rationale: High-performance in-memory data store ideal for caching and queue management. Provides atomic operations for distributed locking and counters.

4. **Bootstrap 5**
   - Rationale: Widely adopted CSS framework with excellent responsive design capabilities and accessibility features. Reduces custom CSS requirements.

5. **AlpineJS**
   - Rationale: Lightweight JavaScript framework for interactive UI components without the complexity of React or Vue. Integrates seamlessly with Blade templates.

6. **Laravel Breeze**
   - Rationale: Lightweight authentication scaffolding that can be easily customized for multi-role support. Simpler than Jetstream for this application's needs.

7. **Spatie Laravel Permission**
   - Rationale: Industry-standard package for role and permission management with excellent Laravel integration and active maintenance.

### Deployment Considerations
- Containerized deployment using Docker for consistency across environments
- Kubernetes orchestration for high availability and scaling
- Blue-green deployment strategy for zero-downtime updates
- Separate environments for development, testing, staging, and production
- Infrastructure as Code (IaC) using Terraform for environment provisioning
- CI/CD pipeline with automated testing and deployment

## 4. Component Design

### Detailed Component Breakdown

#### 1. User Management Module
- UserController
- RolePermissionService
- UserRepository
- AuthenticationService

#### 2. Trader Management Module
- TraderController
- TraderService
- TraderRepository
- KioskAssignmentService

#### 3. Levy Calculation Module
- LevyController
- LevyCalculationService
- LevyFormulaRepository
- LevyGenerationJob

#### 4. Payment Processing Module
- PaymentController
- PaymentRecordingService
- PaymentRepository
- ReceiptGenerationService

#### 5. Notification Module
- NotificationController
- NotificationTemplateService
- NotificationDispatchService
- NotificationQueueJob

#### 6. Reporting Module
- ReportController
- ReportGenerationService
- DataExportService
- AnalyticsDashboardService

#### 7. Audit Logging Module
- AuditLogService
- EntityChangeObserver
- AuditLogRepository
- AuditLogController

### Responsibility Boundaries

```
┌─────────────────────────────────────────────────────────────┐
│                  User Management Module                     │
└─────────────────────────────────────────────────────────────┘
   │                             ▲
   │ Uses                        │ Authenticates
   ▼                             │
┌─────────────────┐      ┌─────────────────┐
│Trader Management│      │Payment Processing│
│     Module      │◄────►│     Module      │
└─────────────────┘      └─────────────────┘
   │                             ▲
   │ Generates                   │ Records
   ▼                             │
┌─────────────────┐      ┌─────────────────┐
│Levy Calculation │      │   Notification  │
│     Module      │─────►│     Module      │
└─────────────────┘      └─────────────────┘
   │                             │
   │                             │
   ▼                             ▼
┌─────────────────┐      ┌─────────────────┐
│    Reporting    │      │  Audit Logging  │
│     Module      │◄────►│     Module      │
└─────────────────┘      └─────────────────┘
```

### Interaction Diagrams

**Levy Generation and Payment Process:**

```
┌─────────┐  ┌─────────────┐  ┌────────────┐  ┌────────────┐  ┌───────────┐  ┌───────────┐
│  Admin  │  │LevyController│  │LevyService │  │LevyRepository│ │NotificationService│ │Trader│
└────┬────┘  └──────┬──────┘  └─────┬──────┘  └──────┬─────┘  └─────┬─────┘  └────┬────┘
     │              │                │                │              │             │
     │ Generate Levy│                │                │              │             │
     │─────────────>│                │                │              │             │
     │              │ calculateLevy()│                │              │             │
     │              │───────────────>│                │              │             │
     │              │                │ saveLevyData() │              │             │
     │              │                │───────────────>│              │             │
     │              │                │                │ storeLevyData()            │
     │              │                │                │─────────────>│             │
     │              │                │                │              │ notifyTrader()
     │              │                │                │              │────────────>│
     │              │                │                │              │             │
     │ Record Payment                │                │              │             │
     │─────────────>│                │                │              │             │
     │              │ recordPayment()│                │              │             │
     │              │───────────────>│                │              │             │
     │              │                │updatePaymentStatus()          │             │
     │              │                │───────────────>│              │             │
     │              │                │                │generateReceipt()           │
     │              │                │                │─────────────>│             │
     │              │                │                │              │notifyPaymentConfirmed()
     │              │                │                │              │────────────>│
     │              │                │                │              │             │
```

### Data Flow Patterns

1. **Trader Registration Flow**
   - Admin enters trader data → Validation → NIK verification → Trader record created → Kiosk assignment → Notification triggered

2. **Levy Calculation Flow**
   - Scheduled job triggers → Fetch active trader-kiosk pairs → Apply formula → Generate levy records → Store in database → Trigger notifications

3. **Payment Recording Flow**
   - Admin enters payment details → Validate amount → Update levy status → Generate receipt → Store receipt → Notify trader

4. **Reporting Flow**
   - Admin selects report type → Parameters specified → Query builder constructs SQL → Data retrieved → Formatted for display/export

### State Management Approach

1. **Levy Status States**
   - Pending → Partial → Paid → Overdue
   - Transitions managed by PaymentService with appropriate validations

2. **Payment Processing States**
   - Initiated → Recorded → Receipted → Completed
   - State transitions logged in audit trail

3. **Notification States**
   - Queued → Sent → Delivered → Read
   - Failed states handled with retry mechanism

4. **User Session States**
   - Managed through Laravel's built-in session handling
   - Inactivity timeout with configurable duration
   - Forced re-authentication for sensitive operations

## 5. Data Architecture

### Database Schema Design

```
┌───────────────┐       ┌───────────────┐       ┌───────────────┐
│     users     │       │    traders    │       │    kiosks     │
├───────────────┤       ├───────────────┤       ├───────────────┤
│ id            │       │ id            │       │ id            │
│ name          │       │ nik           │       │ market_id     │
│ email         │       │ name          │       │ kiosk_no      │
│ password      │       │ address       │       │ category      │
│ role_id       │       │ phone         │       │ area_m2       │
│ last_login_at │       │ status        │       │ status        │
│ created_at    │       │ created_at    │       │ created_at    │
│ updated_at    │       │ updated_at    │       │ updated_at    │
│ deleted_at    │       │ deleted_at    │       │ deleted_at    │
└───────┬───────┘       └───────┬───────┘       └───────┬───────┘
        │                       │                       │
        │                       │                       │
        │                       │                       │
        │               ┌───────┴───────────────┐      │
        │               │                       │      │
        │               ▼                       ▼      │
┌───────────────┐       ┌───────────────┐       ┌───────────────┐
│     roles     │       │ trader_kiosk  │◄──────│   markets     │
├───────────────┤       ├───────────────┤       ├───────────────┤
│ id            │       │ id            │       │ id            │
│ name          │       │ trader_id     │       │ name          │
│ guard_name    │       │ kiosk_id      │       │ location      │
│ created_at    │       │ start_date    │       │ status        │
│ updated_at    │       │ end_date      │       │ created_at    │
└───────────────┘       │ created_at    │       │ updated_at    │
                        │ updated_at    │       └───────────────┘
                        └───────┬───────┘
                                │
                                │
                                ▼
┌───────────────┐       ┌───────────────┐       ┌───────────────┐
│    receipts   │       │    levies     │       │ levy_formulas │
├───────────────┤       ├───────────────┤       ├───────────────┤
│ id            │       │ id            │       │ id            │
│ payment_id    │       │ trader_kiosk_id│       │ base_rate     │
│ pdf_path      │       │ period_month  │       │ category_mult │
│ generated_at  │       │ due_date      │       │ area_mult     │
│ created_at    │       │ amount        │       │ version       │
│ updated_at    │       │ status        │       │ effective_date│
└───────┬───────┘       │ formula_version│       │ created_at    │
        │               │ created_at    │       │ updated_at    │
        │               │ updated_at    │       └───────────────┘
        │               └───────┬───────┘
        │                       │
        │                       │
        │                       ▼
┌───────────────┐       ┌───────────────┐       ┌───────────────┐
│ notification_logs│     │   payments    │       │  audit_logs   │
├───────────────┤       ├───────────────┤       ├───────────────┤
│ id            │       │ id            │       │ id            │
│ user_id       │       │ levy_id       │       │ user_id       │
│ channel       │       │ paid_at       │       │ action        │
│ template_id   │       │ amount        │       │ entity        │
│ sent_at       │       │ method        │       │ entity_id     │
│ success       │       │ receipt_no    │       │ before_json   │
│ created_at    │       │ collector_name│       │ after_json    │
│ updated_at    │       │ created_at    │       │ ip            │
└───────────────┘       │ updated_at    │       │ ua            │
                        └───────────────┘       │ created_at    │
                                                └───────────────┘
```

### Entity Relationship Diagrams

The database schema follows these key relationships:

1. **One-to-Many Relationships**
   - User has many Audit Logs
   - Trader has many Trader-Kiosk assignments
   - Kiosk has many Trader-Kiosk assignments
   - Market has many Kiosks
   - Levy Formula has many Levies

2. **Many-to-One Relationships**
   - Trader-Kiosk belongs to Trader
   - Trader-Kiosk belongs to Kiosk
   - Levy belongs to Trader-Kiosk
   - Payment belongs to Levy

3. **One-to-One Relationships**
   - Payment has one Receipt
   - User has one Trader (for trader accounts)

### Data Access Patterns

1. **Repository Pattern Implementation**
   - Each entity has a dedicated repository class
   - Repositories abstract database operations from services
   - Query scopes for common filtering operations

2. **Eloquent ORM Usage**
   - Leverage Eloquent relationships for efficient joins
   - Eager loading to prevent N+1 query problems
   - Query builders for complex reporting queries

3. **Read/Write Separation**
   - Heavy reporting queries use read replicas when available
   - Transaction-critical operations use primary database

### Caching Strategy

1. **Application-Level Caching**
   - Cache frequently accessed configuration data
   - Cache levy calculation formulas
   - Cache trader dashboard summary data

2. **Query-Level Caching**
   - Cache expensive reporting queries
   - Cache trader payment history
   - Cache admin dashboard metrics

3. **Cache Invalidation Strategy**
   - Tag-based cache invalidation for related entities
   - Time-based expiration for less critical data
   - Event-driven cache clearing on entity updates

### Data Migration Approach

1. **Initial Deployment**
   - Laravel migrations for schema creation
   - Seeders for reference data (markets, roles, etc.)

2. **Ongoing Schema Changes**
   - Versioned migrations with rollback capability
   - Zero-downtime migration strategy for production

3. **Data Import Strategy**
   - CSV import functionality for initial trader data
   - Validation and error reporting during import
   - Transaction-wrapped imports for atomicity

## 6. API Design

### API Structure and Resources

The API follows RESTful principles with the following resource endpoints:

```
/api/v1/auth
  POST   /login          - Authenticate user and get token
  POST   /logout         - Invalidate current token
  GET    /user           - Get current user profile

/api/v1/traders
  GET    /               - List traders (paginated, filterable)
  POST   /               - Create new trader
  GET    /{id}           - Get trader details
  PUT    /{id}           - Update trader
  DELETE /{id}           - Soft-delete trader
  GET    /{id}/kiosks    - Get trader's kiosks
  GET    /{id}/levies    - Get trader's levies

/api/v1/kiosks
  GET    /               - List kiosks (paginated, filterable)
  POST   /               - Create new kiosk
  GET    /{id}           - Get kiosk details
  PUT    /{id}           - Update kiosk
  DELETE /{id}           - Soft-delete kiosk
  POST   /{id}/assign    - Assign kiosk to trader

/api/v1/levies
  GET    /               - List levies (paginated, filterable)
  POST   /               - Create levy manually
  GET    /{id}           - Get levy details
  PUT    /{id}           - Update levy
  POST   /generate       - Generate levies for period
  GET    /due            - Get due/overdue levies

/api/v1/payments
  GET    /               - List payments (paginated, filterable)
  POST   /               - Record new payment
  GET    /{id}           - Get payment details
  GET    /{id}/receipt   - Get payment receipt

/api/v1/reports
  GET    /daily          - Get daily collection report
  GET    /weekly         - Get weekly collection report
  GET    /monthly        - Get monthly collection report
  GET    /annual         - Get annual collection report
  GET    /overdue        - Get overdue payments report
```

### Authentication and Authorization Approach

1. **Authentication Framework**
   - Laravel Sanctum for API token authentication
   - Token-based stateless authentication for API clients
   - Session-based authentication for web interface
   - CSRF protection for web forms

2. **Authorization Model**
   - Role-Based Access Control using Spatie Permission
   - Policy-based authorization for resources
   - Gate definitions for complex permission checks
   - Middleware for route-level access control

3. **Role Hierarchy**
   - SuperAdmin: Full system access
   - Admin: Trader management, payment recording, reporting
   - Collector: Payment recording only
   - Trader: Personal levy information only

### Request/Response Formats

All API endpoints use JSON for request and response bodies:

**Request Example:**
```json
{
  "trader_id": 123,
  "amount": 50000,
  "paid_at": "2025-06-15T10:30:00Z",
  "method": "cash",
  "collector_name": "John Doe",
  "notes": "Monthly payment for June 2025"
}
```

**Response Example:**
```json
{
  "data": {
    "id": 456,
    "levy_id": 789,
    "amount": 50000,
    "paid_at": "2025-06-15T10:30:00Z",
    "method": "cash",
    "receipt_no": "RCPT-202506-0123",
    "collector_name": "John Doe",
    "status": "completed",
    "created_at": "2025-06-15T10:32:15Z"
  },
  "meta": {
    "receipt_url": "/api/v1/payments/456/receipt"
  }
}
```

### Status Codes and Error Handling

The API uses standard HTTP status codes:

- 200 OK: Successful request
- 201 Created: Resource successfully created
- 400 Bad Request: Invalid input data
- 401 Unauthorized: Authentication required
- 403 Forbidden: Insufficient permissions
- 404 Not Found: Resource not found
- 422 Unprocessable Entity: Validation errors
- 500 Internal Server Error: Server-side error

Error responses follow a consistent format:

```json
{
  "error": {
    "code": "validation_error",
    "message": "The given data was invalid.",
    "details": {
      "amount": ["The amount must be greater than 0."],
      "paid_at": ["The paid at date cannot be in the future."]
    }
  }
}
```

### Rate Limiting and Security Measures

1. **Rate Limiting**
   - Global rate limiting: 60 requests per minute per IP
   - Authentication endpoints: 5 requests per minute per IP
   - Trader-specific endpoints: 30 requests per minute per trader

2. **Security Headers**
   - Content-Security-Policy to prevent XSS
   - X-Content-Type-Options: nosniff
   - X-Frame-Options: DENY
   - Strict-Transport-Security: max-age=31536000

3. **Input Validation**
   - Request validation using Laravel Form Requests
   - Sanitization of all user inputs
   - Parameterized queries to prevent SQL injection

## 7. Security Architecture

### Authentication Framework Implementation

1. **Web Authentication**
   - Laravel Breeze with customizations for multi-role support
   - Email/password authentication with strong password policies
   - Remember-me functionality with secure cookie handling
   - Account lockout after failed login attempts

2. **API Authentication**
   - Laravel Sanctum for token-based authentication
   - Token expiration and rotation policies
   - Scope-based token restrictions

3. **Session Management**
   - Secure, HTTP-only cookies for session storage
   - Session timeout after configurable inactivity period
   - Session regeneration on privilege level change

### Authorization Model and Permissions

1. **Role Definitions**
   - SuperAdmin: System-wide access and configuration
   - Admin: Trader management, levy configuration, reporting
   - Collector: Payment recording and receipt generation
   - Trader: Personal levy information only

2. **Permission Sets**
   - traders.view, traders.create, traders.edit, traders.delete
   - kiosks.view, kiosks.create, kiosks.edit, kiosks.delete
   - levies.view, levies.create, levies.edit, levies.generate
   - payments.view, payments.create, payments.reconcile
   - reports.view, reports.export
   - settings.view, settings.edit

3. **Implementation Strategy**
   - Spatie Laravel Permission for role/permission storage
   - Policy classes for resource authorization
   - Middleware for route protection
   - Blade directives for UI element visibility control

### Data Protection Mechanisms

1. **Encryption**
   - Database encryption for sensitive fields (NIK, phone numbers)
   - Laravel's built-in encryption for stored sensitive data
   - TLS 1.3 for all data in transit

2. **Data Masking**
   - Partial masking of NIK numbers in UI and logs
   - Full masking of sensitive data in error reports

3. **Data Retention**
   - Configurable retention periods for different data types
   - Automated data anonymization for expired records
   - Secure data deletion processes

### Security Controls and Compliance Measures

1. **UU PDP Compliance**
   - Explicit consent collection and management
   - Data processing registry and documentation
   - Data subject access request handling
   - Right to be forgotten implementation (for non-financial data)

2. **Audit Logging**
   - Comprehensive logging of all security-relevant events
   - Immutable audit trail for financial transactions
   - User action logging with before/after state capture
   - IP address and user agent tracking

3. **Vulnerability Management**
   - Regular dependency scanning and updates
   - OWASP Top 10 mitigation strategies
   - Input validation and output encoding
   - Prepared statements for all database queries

### Audit Logging and Monitoring

1. **Audit Log Implementation**
   - Observer pattern for entity change tracking
   - JSON serialization of entity states
   - Immutable storage with append-only design
   - Searchable admin interface for audit review

2. **Monitoring Strategy**
   - Laravel Telescope for development monitoring
   - Custom health check endpoints
   - Performance metric collection
   - Error rate monitoring and alerting

3. **Incident Response**
   - Automated alerting for security anomalies
   - Defined incident response procedures
   - Forensic data preservation mechanisms

## 8. Scalability and Performance

### Scaling Strategy

1. **Horizontal Scaling**
   - Stateless application design for horizontal scaling
   - Load balancing across multiple application instances
   - Session storage in Redis for shared state
   - Database read replicas for query distribution

2. **Vertical Scaling**
   - Resource allocation optimization based on usage patterns
   - Database server sizing for peak transaction volumes
   - Memory optimization for caching and queue processing

3. **Database Scaling**
   - Table partitioning for historical levy and payment data
   - Indexing strategy for common query patterns
   - Query optimization for reporting workloads

### Performance Optimization Techniques

1. **Application Level**
   - Route caching in production
   - Config caching in production
   - Optimized Composer autoloader
   - Eager loading of Eloquent relationships

2. **Database Level**
   - Indexed queries for frequent operations
   - Query optimization and monitoring
   - Connection pooling
   - Prepared statement caching

3. **Frontend Level**
   - Asset bundling and minification
   - Lazy loading of UI components
   - Optimized Alpine.js usage
   - HTTP/2 for parallel asset loading

### Resource Management Approach

1. **Memory Management**
   - Chunk processing for large data sets
   - Garbage collection optimization
   - Memory limit monitoring and alerting

2. **CPU Utilization**
   - Queue-based processing for CPU-intensive tasks
   - Background job scheduling during off-peak hours
   - Process isolation for resource-intensive operations

3. **I/O Optimization**
   - Batched database operations
   - Efficient file handling for receipt generation
   - Asynchronous logging

### Caching Implementation Details

1. **Data Caching**
   - Redis as primary cache store
   - Trader dashboard data cached for 15 minutes
   - Levy calculation formulas cached until changed
   - Report results cached for configurable duration

2. **Query Caching**
   - Frequently accessed queries cached with tags
   - Cache invalidation on entity updates
   - Selective query caching based on complexity

3. **Static Asset Caching**
   - Browser caching with appropriate cache headers
   - Versioned asset URLs for cache busting
   - CDN integration for static assets

### High Availability Design

1. **Redundancy**
   - Multiple application instances behind load balancer
   - Database primary with standby replica
   - Redis cluster for cache and queue reliability

2. **Failover Mechanisms**
   - Automated database failover
   - Health checks for application instances
   - Circuit breakers for external dependencies

3. **Disaster Recovery**
   - Daily database backups
   - Point-in-time recovery capability
   - Documented recovery procedures with RTO/RPO targets

## 9. Implementation Guidance

### Development Approach Recommendations

1. **Code Organization**
   - Follow Laravel's standard directory structure
   - Use namespaced modules for major feature areas
   - Implement service classes for business logic
   - Use repositories for data access abstraction

2. **Coding Standards**
   - PSR-12 coding style
   - Laravel naming conventions
   - Comprehensive PHPDoc comments
   - Type hints and return type declarations

3. **Testing Strategy**
   - Unit tests for all service classes
   - Feature tests for HTTP endpoints
   - Database tests for repository classes
   - Browser tests for critical user flows

### Major Implementation Considerations

1. **Levy Calculation Engine**
   - Implement as a flexible, configurable service
   - Support for multiple formula versions
   - Audit trail for formula changes
   - Validation rules for formula parameters

2. **Payment Recording System**
   - Transaction-wrapped payment processing
   - Idempotent payment recording
   - Receipt generation with unique numbering
   - Reconciliation tools for daily balancing

3. **Notification System**
   - Queue-based asynchronous processing
   - Template-driven notification content
   - Multi-channel delivery capability
   - Delivery tracking and retry mechanism

### Potential Technical Challenges

1. **Data Migration from Legacy Systems**
   - Develop robust import tools with validation
   - Plan for data cleansing and normalization
   - Consider phased migration approach

2. **Offline Capability**
   - Implement progressive enhancement approach
   - Consider service workers for critical functions
   - Local storage for temporary data persistence

3. **Performance at Scale**
   - Monitor query performance as data grows
   - Implement database partitioning strategy
   - Optimize reporting queries with materialized views

### Phasing Strategy Recommendations

1. **Phase 1 (MVP)**
   - Core trader and kiosk management
   - Basic levy calculation and assignment
   - Cash payment recording and receipts
   - Essential reporting capabilities
   - Audit logging foundation

### Testing Approach Suggestions

1. **Unit Testing**
   - PHPUnit for service and repository classes
   - Mockery for dependency isolation
   - 90% code coverage target for core services

2. **Integration Testing**
   - API endpoint testing with real database
   - Authentication and authorization testing
   - Notification delivery verification

3. **Performance Testing**
   - Load testing with realistic user scenarios
   - Database performance under load
   - Caching effectiveness measurement

4. **Security Testing**
   - OWASP-based vulnerability scanning
   - Penetration testing before production
   - Data protection compliance verification
