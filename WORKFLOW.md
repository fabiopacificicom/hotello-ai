# From Prototype to Implementation Workflow

Referer to the mockups for the full guests landing page experience and the hotel manager dashboard to understand the user interface and workflow for both types of users.

## Milestones

The goal is to build the actual software starting from the initial prototype that helps to visualise what to build.

Here are the steps:

### Milestone 1: Initial Prototype and Authentication

Documents to refer: Brief.md, AGENTS.md

- product decomposition: from the available brief and  prototype we decompose the full system and produce the ADR with the application flow, its components and data schema with a ER diagram (read the Agents.md for details)
- the adr features are then planned in dedicated specs
- we organise the specs in a roadmap and start development
- we develop the hotel front page as per the prototype as main application landing page
- we add authentication so the logged in hotel manager can see its dashboard as per the prototype.
- deploy on a tunnel as this is the first milestone  reached.

**Acceptance step:**

- a guest can see the hotel page ( yes bookings still mocked but comes next)
- manager can register and login ( yes the manager panel is just mocked for now)

This will show the authentication and authorization issue as described in the security contents of the course as they can use the app via the tunnel and each will be able to register and see the manager panel!!

--- Milestone 1 done. --

### Milestone 2: Deployment and Real Booking System

Next we can take the tunnel down and build the real application one increment at the time using the briefs written and start implementing them with the agent in autopilot.

- we figure out the hosting and domain bits with the slides on hand
- check the agent work reached a point we can deploy to a production server with a real booking system and the manager that can see booked rooms  then with the deploy skill
(Likely will demo laravel cloud) we deploy to production and connect to a new or existing domain.

--- Milestone 2 done ---

Once public we can keep implementing the remaining features and set other milestones.
